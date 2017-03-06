<?php
namespace App\Controller;

use Respect\Validation\Validator as v;

class ReportController extends ObjectController{

    public function __construct(){
        parent::__construct("Report");
    }
    public function create(){
        $inputs = ['commentary_id'];
        if(!v::numeric()->validate($_POST[$inputs[0]])){
            $this->error("Le format de l'id est incorrect.",'/post/see/'.$_POST['slug']);
        }
        //Mise à jour du commentaire
        $commentaryManager = new \App\PDOManager\commentaryManager();
        $numberOfReports = $commentaryManager->findOneBy('id',$_POST['commentary_id'],['number_of_reports'])['number_of_reports'];
        $numberOfReports++;
        $commentaryManager->update($_POST['commentary_id'],['number_of_reports' => $numberOfReports ]);
        //Création du report
        $arrayObj['commentary_id'] = $_POST[$inputs[0]];
        $arrayObj['user_id'] = $_SESSION['auth']['id'];
        $manager = $this->getManager()->create($arrayObj);
        $this->success("Le signalement a bien été pris en compte.",'/post/see/'.$_POST['slug']);
    }
}