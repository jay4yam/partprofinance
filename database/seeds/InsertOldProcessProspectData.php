<?php

use Illuminate\Database\Seeder;
use App\Models\ProcessProspect;

class InsertOldProcessProspectData extends Seeder
{
    //recup le fichier
    private function getJsonfile($name)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/'.$name);

        return file_get_contents($filePath);
    }

    private function getResults()
    {
        $file = $this->getJsonfile('process_prospects.json');

        //Récupère le contenu du fichier
        return json_decode(utf8_encode($file));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $results = $this->getResults();

        foreach ($results as $result)
        {
            $process = new ProcessProspect();

            $process->status = $result->status;
            $process->relance_status = $result->relance_status;
            $process->relance_j1 = $result->relance_j1;
            $process->relance_j4 = $result->relance_j4;
            $process->notes = $result->notes;
            $process->temp_prospects_id = $result->temp_prospects_id;

            $process->save();
        }
    }
}
