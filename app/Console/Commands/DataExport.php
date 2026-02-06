<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DataExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:export {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export data to file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');

        $valid = ['phone', 'email'];

        if (!in_array($type, $valid, true)) {

            $this->error("Valor inválido para type. Opciones válidas: " . implode(', ', $valid));
            
            return self::FAILURE;
        }

        $types = "";

        switch ($type) {

            case 'phone':
                
                $types = "4, 8";
                
                break;
            
            case 'email':
                
                $types = "1, 2, 3";
                
                break;
        }

        $query = "
            SELECT
                C.dato,
                CONCAT(E.rut, E.dv) AS rut,
                E.nombres,
                E.apellido_paterno,
                E.apellido_materno,
                V.patente,
                V.marca,
                V.modelo,
                V.`version`,
                V.ano,
                V.color,
                V.id_categoria_urbana,
                V.id_categoria_interurbana,
                CONCAT_WS(
                    ' ',
                    D.calle,
                    D.numero,
                    D.departamento,
                    D.comuna,
                    D.comentario
                ) AS direccion
            FROM contacto AS C
                INNER JOIN entidad AS E
                    ON C.id_entidad = E.id
                INNER JOIN contrato_vehiculo AS CV
                    ON E.id_contrato = CV.id_contrato
                INNER JOIN vehiculo AS V
                    ON CV.id_vehiculo = V.id
                INNER JOIN direccion AS D
                    ON CV.id_contrato = D.id_contrato
            WHERE
                C.tipo IN ($types)
                AND C.alta = 1
                AND E.alta = 1
                AND V.alta = 1
                AND D.alta = 1
        ";

        $date = date('Y-m-d-H-i-s');

        $filename = "data-{$type}-{$date}.csv";

        $path = storage_path("app/{$filename}");

        $handle = fopen($path, 'w');

        $first = true;

        $connection = DB::connection('mysql_dc_ctrl')
                    ->table('dbs')
                    ->where('mode', 'active')
                    ->value('connection');

        $i = 0;

        $this->info("Buscando datos...");

        foreach (DB::connection($connection)->cursor($query) as $row) {

            $i++;

            if ($i % 10000 === 0) {

                $this->line("Procesados {$i} registros...");
            }

            $row = (array) $row;

            if ($first) {
        
                fputcsv($handle, array_keys($row), ';');
            
                $first = false;
            }

            fputcsv($handle, $row, ';');
        }

        $this->info("Archivo $filename generado en storage/app");

        fclose($handle);
    }
}
