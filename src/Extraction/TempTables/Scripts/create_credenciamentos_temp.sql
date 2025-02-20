SELECT
	r.codpes AS 'numero_usp'
	,r.codare AS 'codigo_area'
	,r.nivare AS 'nivel'
	,r.tiport AS 'tipo_credenciamento'
	,r.dtavalini AS 'data_inicio_validade'
	,r.dtavalfim AS 'data_fim_validade'
INTO #fflch_creds
FROM R25CRECREDOC r
WHERE r.codare BETWEEN 8000 AND 9000;


/*
Insert into a temp table ME (Master) supervisor certifications that were obtained
alongside DO (PhD) supervisor certifications
Those are deprecated. Now it's implicit: if you have a DO licensure, you have a ME one 
*/
SELECT f2.*
INTO #deletar_creds
FROM #fflch_creds f
	INNER JOIN #fflch_creds f2
		ON f.numero_usp = f2.numero_usp 
			AND f.codigo_area = f2.codigo_area 
			AND f.data_inicio_validade = f2.data_inicio_validade 
WHERE f.nivel = 'DO' AND f2.nivel = 'ME' ;


-- Delete those old ME supervisor certifications.
DELETE FROM #fflch_creds
WHERE EXISTS (
	SELECT 1
	FROM #deletar_creds d
	WHERE #fflch_creds.numero_usp = d.numero_usp 
		AND #fflch_creds.codigo_area = d.codigo_area 
		AND #fflch_creds.data_inicio_validade = d.data_inicio_validade
		AND #fflch_creds.nivel = d.nivel
);


-- Create a column to check if that is the professor's last certification in that area
SELECT 
	f.*
	,CASE
		WHEN max_date IS NOT NULL THEN 'S'
		ELSE 'N'
		END AS 'ultimo_credenciamento_area'
INTO #last_credenciamento_added
FROM #fflch_creds f
	LEFT JOIN (
		SELECT
			f2.numero_usp
			,f2.codigo_area
			,MAX(f2.data_inicio_validade) AS 'max_date'
		FROM #fflch_creds f2
		GROUP BY f2.numero_usp, f2.codigo_area
	) u
		ON f.numero_usp = u.numero_usp
			AND f.codigo_area = u.codigo_area
			AND f.data_inicio_validade = u.max_date;


--
SELECT * 
INTO #areas
FROM NOMEAREA n
WHERE codare BETWEEN 8000 AND 9000;

UPDATE #areas
SET dtafimare = DATEADD(year, 10, GETDATE())
WHERE dtafimare IS NULL;

UPDATE #areas
SET dtainiare = '1900-01-01 00:00:00.000'
WHERE DATEDIFF(day, dtainiare, dtafimare) <= 1;

UPDATE #areas
SET dtainiare = '1900-01-01 00:00:00.000'
WHERE codare = 8133 AND dtainiare = '1971-06-28 00:00:00.000';

--
SELECT * 
INTO #programas
FROM NOMECURSO n
WHERE codcur BETWEEN 8000 AND 9000;

UPDATE #programas
SET dtafimcur = DATEADD(year, 10, GETDATE())
WHERE dtafimcur IS NULL;

UPDATE #programas
SET dtainicur = '1900-01-01 00:00:00.000'
WHERE codcur = 8003 AND dtainicur = '1971-06-28 00:00:00.000'
    OR codcur = 8005 AND dtainicur = '1970-11-16 00:00:00.000'
    OR codcur = 8008 AND dtainicur = '1970-12-28 00:00:00.000';

--
SELECT
    l.*
    ,a.nomare AS 'nome_area'
    ,a.codcur AS 'codigo_programa'
    ,p.nomcur AS 'nome_programa'
INTO #credenciamentos
FROM #last_credenciamento_added l
    LEFT JOIN #areas a ON l.codigo_area = a.codare AND l.data_inicio_validade BETWEEN a.dtainiare AND a.dtafimare
    LEFT JOIN #programas p ON a.codcur = p.codcur AND l.data_inicio_validade BETWEEN p.dtainicur AND p.dtafimcur;


-- Drop all unnecessary temp tables
DROP TABLE #deletar_creds;
DROP TABLE #fflch_creds;
DROP TABLE #areas;
DROP TABLE #programas;

