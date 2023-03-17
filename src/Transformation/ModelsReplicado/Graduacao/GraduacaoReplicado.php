<?php

namespace Src\Transformation\ModelsReplicado\Graduacao;

use Src\Transformation\Utils\Utils;
use Src\Transformation\Utils\Deparas;
use Src\Transformation\ModelsReplicado\Interfaces\Mapper;

class GraduacaoReplicado implements Mapper
{
    public function mapping(Array $graduacao)
    {
        $graduacao = Utils::emptiesToNull($graduacao);

        $properties = [
            'idGraduacao' => strtoupper(md5($graduacao['numeroUSP'] . $graduacao['sequenciaCurso'])),
            'numeroUSP' => (int)$graduacao['numeroUSP'],
            'sequenciaCurso' => (int)$graduacao['sequenciaCurso'],
            'situacaoCurso' => Deparas::situacoesGR[$graduacao['situacaoCurso']] ?? $graduacao['situacaoCurso'],
            'dataInicioVinculo' => $graduacao['dataInicioVinculo'],
            'dataFimVinculo' => $graduacao['dataFimVinculo'],
            'codigoCurso' => (int)$graduacao['codigoCurso'],
            'nomeCurso' => $graduacao['nomeCurso'],
            'tipoIngresso' => Deparas::ingressos[$graduacao['tipoIngresso']] ?? $graduacao['tipoIngresso'],
            'categoriaIngresso' => $graduacao['categoriaIngresso'],
            'rankIngresso' => $graduacao['rankIngresso'],
            'tipoEncerramentoBacharel' => $graduacao['tipoEncerramentoBacharel'],
            'dataEncerramentoBacharel' => $graduacao['dataEncerramentoBacharel'],
        ];

        return $properties;
    }
}