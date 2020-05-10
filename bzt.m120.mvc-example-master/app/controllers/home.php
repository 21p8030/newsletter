<?php

class Home extends Controller {

    protected $user;
    public function __construct() {
        $this->user = $this->model('User');
    }

    public function index($name = '') {
        
        $user = $this->user;
        $user->name = $name;
        $this->view('home/index', ['name' => $user->name]);

        $this->goto('home', 'newsletter');
    }


    
    public function newsletter(){
    //schauen ob ein post vorhanden 
    if(isset($_POST['Email'])){
        $file = fopen('liste.txt', 'a+');

        //schauen ob mail schon registriert
        $write = true;
        while(!feof($file)){
                if(trim(fgets($file)) == "Mail ".$_POST['Email']){
                    //Mail adresse wurde bereits erfasst also muss nichts geschrieben werden
                    $write = false;
                    //exit;
                }    
        }

        while(!feof($file)){
            if($write == true){
                if(trim(fgets($file)) == "Vorname: ".$_POST['Vorname']){
                    if(trim(fgets($file)) == "Nachname: ".$_POST['Nachname']){
                        if(trim(fgets($file)) == "Strasse: ".$_POST['Strasse']){
                            if(trim(fgets($file)) == "Ort: ".$_POST['Ort']){
                                echo "Alles gleich ausser Mail";
                                confirm("Email Adresse überschreiben");
                            } 
                        } 
                    }
                }
            }   
        }
     //   $newslettertest = array($_POST['Email'],$_POST['Vorname'],$_POST['Nachname'],$_POST['Strasse'],$_POST['Ort']);
        
        
       // $anzahl = count ( $newslettertest );
       // echo "<p>Es gibt $anzahl Einträge</p>";
       // echo "<ul>";
         
       /* for ($x = 0; $x < $anzahl; $x++)
        {
            echo "<li>Eintrag von $x ist $newslettertest[$x] </li>";
        }
         
        echo "</ul>";
        */

        // fehler meldung oder mail in file schreiben
        if($write == true){
           // fwrite($file, $newslettertest);
           fwrite($file, "Mail ".$_POST['Email']."\n");
            fwrite($file, "Vorname: ".$_POST['Vorname']."\n");
            fwrite($file, "Nachname: ".$_POST['Nachname']."\n");
            fwrite($file, "Strasse: ".$_POST['Strasse']."\n");
            fwrite($file, "Ort: ".$_POST['Ort']."\n");
            echo $_POST['Email'].' wurde für Sie erfasst';
        }else{
            echo $_POST['Email'].' wurde bereits erfasst';
        }

    }

    $this->view('home/newsletter');
    }
}