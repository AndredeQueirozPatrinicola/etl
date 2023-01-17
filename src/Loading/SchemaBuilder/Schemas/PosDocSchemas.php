<?php

namespace Src\Loading\SchemaBuilder\Schemas;

class PosDocSchemas
{
    const alunos_posdoutorado = [

        "tableName" => "alunos_posdoutorado",

        "columns" => [
            "numeroUSP" => [
                "type" => "integer"
            ],
            "nomeAluno" => [
                "type" => "string",
                "size" => 256
            ],
            "anoNascimento" => [
                "type" => "smallInteger"
            ],
            "nacionalidade" => [
                "type" => "string",
                "size" => 128,
                "nullable" => true
            ],
            "cidadeNascimento" => [
                "type" => "string",
                "size" => 128,
                "nullable" => true
            ],
            "estadoNascimento" => [
                "type" => "string",
                "size" => 2,
                "nullable" => true
            ],
            "paisNascimento" => [
                "type" => "string",
                "size" => 128,
                "nullable" => true
            ],
            "raca" => [
                "type" => "string",
                "size" => 32,
                "nullable" => true
            ],
            "sexo" => [
                "type" => "string",
                "size" => 1,
                "nullable" => true
            ],
            "created_at" => [
                "type" => "timestamp"
            ],
            "updated_at" => [
                "type" => "timestamp"
            ],
        ],

        "primary" => [
            "numeroUSP"
        ],
        
        "foreign" => [
            //
        ]
    ];

    const posdoutorados = [

        "tableName" => "posdoutorados",

        "columns" => [
            "idProjeto" => [
                "type" => "string",
                "size" => 12
            ],
            "programa" => [
                "type" => "char",
                "size" => 2
            ],
            "numeroUSP" => [
                "type" => "integer"
            ],
            "dataInicioProjeto" => [
                "type" => "dateTime",
                "nullable" => true
            ],
            "dataFimProjeto" => [
                "type" => "dateTime",
                "nullable" => true
            ],
            "situacaoProjeto" => [
                "type" => "string",
                "size" => 16
            ],
            "codigoDepartamento" => [
                "type" => "integer",
                "nullable" => true
            ],
            "nomeDepartamento" => [
                "type" => "string",
                "size" => 256,
                "nullable" => true
            ],
            "tituloProjeto" => [
                "type" => "string",
                "size" => 1024
            ],
            "created_at" => [
                "type" => "timestamp"
            ],
            "updated_at" => [
                "type" => "timestamp"
            ],
        ],

        "primary" => [
            "idProjeto"
        ],
        
        "foreign" => [
            [
                "keys" => "numeroUSP",
                "references" => "numeroUSP",
                "on" => "alunos_posdoutorado",
                "onDelete" => "cascade"
            ],
        ]
    ];
}