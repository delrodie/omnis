<?php


namespace App\Utilities;


use Twig\Environment;

class GestionMail
{
    private $swift_mail;
    private $template;

    public function __construct(\Swift_Mailer $swift_mail, Environment $template)
    {
        $this->swift_mail= $swift_mail;
        $this->template = $template;
    }

    /**
     * Envoie de mail apres action
     *
     * @param $objet
     * @param $user
     * @param null $code
     * @return bool
     */
    public function envoiMail($objet, $user, $code = null)
    {
        // Envoi de mail de
        $email = (new \Swift_Message($objet))
            ->setFrom('delrodieamoikon@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->contenu($code))
            ;
        $this->swift_mail->send($email);

        return true;
    }

    /**
     * Notification de confirmation d'enregistrement de la pré-inscription
     *
     * @param $objet
     * @param $etudiant
     * @return bool
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notificationInscriptionTest($objet, $etudiant)
    {
        // Envoi d'email à l'etudiant concerné
        $email_etudiant = (new \Swift_Message($objet))
            ->setFrom('no-reply@selfbrandingci.com')
            ->setTo($etudiant->getUser()->getEmail())
            //->setBcc('delrodieamoikon@gmail.com')
            ->setBcc(['delrodieamoikon@gmail.com'])
            ->setBody(
                $this->template->render('email/inscription_test_etudiant.html.twig',[
                    'etudiant' => $etudiant,
                ]),
                'text/html'
            )
            ;

        // Envoi d'email aux administrateurs concernés
        $email_admin = (new \Swift_Message("PRE-INSCRIPTION AU TEST D'ENTREE"))
            ->setFrom('no-reply@selfbrandingci.com')
            ->setTo('pareabel58@gmail.com')
            //->setBcc('delrodieamoikon@gmail.com')
            ->setBcc(['delrodieamoikon@gmail.com'])
            ->setBody(
                $this->template->render('email/inscription_test_admin.html.twig',[
                    'etudiant' => $etudiant,
                ]),
                'text/html'
            )
        ;

        $this->swift_mail->send($email_etudiant);
        $this->swift_mail->send($email_admin);

        return true;
    }

    /**
     * Les messages pour l'envoi de mail
     * 0 = Message de confirmation de creation de compte
     *
     * @param $code
     * @return string
     */
    protected function contenu($code):?string
    {
        $confirmation = "Votre inscription a été effectuée avec succès";
        $default = "l'utilisateur est connecté";

        switch ($code){
            case 0:
                $contenu = $confirmation;
                break;
            default:
                $contenu = $default;
                break;
        }

        return $contenu;
    }
}