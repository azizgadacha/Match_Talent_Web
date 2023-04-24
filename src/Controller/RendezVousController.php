<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use GuzzleHttp\Client;
use Symfony\Component\Mime\Part;
use Symfony\Component\Mime\InlineImage;

use App\Entity\Annonce;
use App\Entity\Postulation;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use App\Repository\RendezVousRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(Request $request,PaginatorInterface $paginator,RendezVousRepository $rendezVousRepository): Response
    {
        $data=$rendezVousRepository->findAll();
        $pagination = $paginator->paginate($rendezVousRepository->findAll(), $request->query->getInt('page', 1),
            1 // items per page
        );
        return $this->render('rendez_vous/index.html.twig', [
            'pagination' => $pagination,]);
    }
    #[Route('/admin', name: 'app_admin_rendez_vous_index', methods: ['GET'])]
    public function indexAdmin(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/indexAdmin.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailerInterface $mailer, ManagerRegistry $doctrine,RendezVousRepository $rendezVousRepository, AnnonceRepository $annonceRepository,CandidatureRepository $candidatureRepository): Response
    {
        $idCandidature = $request->query->get('idCandidature');
        $Candidature= $candidatureRepository->find($idCandidature);
        $rendezVou = new RendezVous();
        $client = new Client();

        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
                'userPostulation' => $Candidature->getUtilisateurAssocier(),
                'annoncePostulation' => $Candidature->getAnnonceAssocier(),
            ]);
             // Update the entity properties
                $postulation->setEtat('accepter');
                $entityManager->flush();
            $rendezVou->setUserRendezVous($Candidature->getUtilisateurAssocier());
            $rendezVou->setAnnonceAssocierRendezVous($Candidature->getAnnonceAssocier());
            $rendezVousRepository->save($rendezVou,true);
            $client = new Client();

            // Utilisez la méthode GET de Guzzle pour appeler l'API et générer le code QR
            $response = $client->get('https://api.qr-code-generator.com/v1/create', [
                'query' => [
                    'access-token' => 'NTF5PVKqCb6RZlRy6P-gMDEcmVzq2MD2QP31BnPCnZdncHFS-BV3OWCAY8PllzLF',
                    'data' => 'hellohhhhhhhhhhh',
                    'file' => 'png',
                    'size' => '300',
                ]
            ]);
            $qrCodeImage = (string) $response->getBody();
           // $qrCodeAttachment = new Part ($qrCode);
            //$qrCodeAttachment->contentDisposition('attachment', 'qr-code.png');


            $email = (new Email())
                ->from('validation.message@gmail.com')
                ->to('aziz.gadacha@esprit.tn')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->embed($qrCodeImage, 'qr_code.png', 'image/png') // Attach the image

                ->html('<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"> <head> <!--[if gte mso 9]> <xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml> <![endif]--> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="x-apple-disable-message-reformatting"> <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><title></title> <style type="text/css"> @media only screen and (min-width: 620px) { .u-row { width: 600px !important; } .u-row .u-col { vertical-align: top; } .u-row .u-col-50 { width: 300px !important; } .u-row .u-col-100 { width: 600px !important; } } @media (max-width: 620px) { .u-row-container { max-width: 100% !important; padding-left: 0px !important; padding-right: 0px !important; } .u-row .u-col { min-width: 320px !important; max-width: 100% !important; display: block !important; } .u-row { width: 100% !important; } .u-col { width: 100% !important; } .u-col > div { margin: 0 auto; } } body { margin: 0; padding: 0; } table, tr, td { vertical-align: top; border-collapse: collapse; } p { margin: 0; } .ie-container table, .mso-container table { table-layout: fixed; } * { line-height: inherit; } a[x-apple-data-detectors'."='true'] { color: inherit !important; text-decoration: none !important; } table, td { color: #000000; } #u_body a { color: #0000ee; text-decoration: underline; } @media (max-width: 480px) { #u_content_image_1 .v-src-width { width: auto !important; } #u_content_image_1 .v-src-max-width { max-width: 40% !important; } #u_content_heading_1 .v-font-size { font-size: 38px !important; } #u_content_image_3 .v-src-width { width: 100% !important; } #u_content_image_3 .v-src-max-width { max-width: 100% !important; } #u_content_text_5 .v-container-padding-padding { padding: 10px 30px 11px 10px !important; } #u_content_text_3 .v-container-padding-padding { padding: 15px 10px 20px !important; } } </style> ".' <!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" type="text/css"><!--<![endif]--> </head> <body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #536068;color: #000000"> <!--[if IE]><div class="ie-container"><![endif]--> <!--[if mso]><div class="mso-container"><![endif]--> <table id="u_body" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #536068;width:100%" cellpadding="0" cellspacing="0"> <tbody> <tr style="vertical-align: top"> <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #536068;"><![endif]--> <div class="u-row-container" style="padding: 0px;background-color: transparent"> <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #f1f2f6;"> <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #f1f2f6;"><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]--> <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]--> <table id="u_content_image_1" style="font-family'.":'Montserrat',sans-serif".';" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:30px 10px 31px;font-family'.":'Montserrat',sans-serif".';" align="left"> <table width="100%" cellpadding="0" cellspacing="0" border="0"> <tr> <td style="padding-right: 0px;padding-left: 0px;" align="center"> <img align="center" border="0" src="https://scontent.ftun6-1.fna.fbcdn.net/v/t1.15752-9/324410229_8827794603958301_1785396642166846607_n.png?_nc_cat=106&ccb=1-7&_nc_sid=ae9488&_nc_ohc=IJqW56wBU6AAX_4wj_K&_nc_ht=scontent.ftun6-1.fna&oh=03_AdTPgYmA2nZlOzjpQynj7d5SEE2i4LXGmaIZhZn3UyGO2A&oe=6463B4DE" alt="Logo" title="Logo" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 24%;max-width: 139.2px;" width="139.2" class="v-src-width v-src-max-width"/> </td> </tr> </table></td></tr> </tbody></table><!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div><div class="u-row-container" style="padding: 0px;background-color: transparent"><div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #fbfcff;"> <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #fbfcff;"><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--> <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--> <table id="u_content_heading_1" style="font-family'.":'Montserrat',sans-serif".';" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:50px 10px 30px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <h1 class="v-font-size" style="margin: 0px; color: #27187e; line-height: 140%; text-align: center; word-wrap: break-word; font-family'.": 'Montserrat'".',sans-serif; font-size: 36px; ">Vous avez un Nouveau <br />rendez-vous avec '.$rendezVou->getAnnonceAssocierRendezVous()->getNomSocieté().'</h1 </td> </tr> </tbody> </table> <table id="u_content_image_3" style="font-family'.":'Montserrat',sans-serif".';" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:15px 10px 40px;font-family'.":'Montserrat',sans-serif".';" align="left"> <table width="100%" cellpadding="0" cellspacing="0" border="0"> <tr> <td style="padding-right: 0px;padding-left: 0px;" align="center"> <img align="center" border="0" src="https://scontent.ftun6-1.fna.fbcdn.net/v/t1.15752-9/339385600_1945448085816296_1433839456195691958_n.png?_nc_cat=105&ccb=1-7&_nc_sid=ae9488&_nc_ohc=mfh-D2XoeEQAX8HQX_y&_nc_ht=scontent.ftun6-1.fna&oh=03_AdS--bMGTL_qSTPqasP4yS0UOGv897vqhCYy6mdhVkMs1A&oe=6463DDA9" alt="Hero Image" title="Hero Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 47%;max-width: 272.6px;" width="272.6" class="v-src-width v-src-max-width"/> </td>  </tr></table></td> </tr> </tbody> </table> <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--> </div> </div> <!--[if (mso)|(IE)]></td><![endif]--> <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--> </div> </div> </div> <div class="u-row-container" style="padding: 0px;background-color: transparent"> <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;"> <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #ffffff;"><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--> <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--> <table id="u_content_text_5" style="font-family'.":'Montserrat',".'sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:40px 30px 20px 40px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <div class="v-font-size" style="color: #4b4a4a; line-height: 190%; text-align: left; word-wrap: break-word;"> <p style="font-size: 14px; line-height: 190%;"><span style="font-size: 18px; line-height: 34.2px;"><strong><span style="line-height: 34.2px; font-size: 18px;">Bonjour ,</span></strong></span></p> <p style="font-size: 14px; line-height: 190%;"><span style="font-size: 16px; line-height: 30.4px;">Vous avez un nouveau rendez-vous avec </span></p> </div> </td> </tr> </tbody> </table> <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--> </div> </div> <!--[if (mso)|(IE)]></td><![endif]--> <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--> </div> </div> </div> <div class="u-row-container" style="padding: 0px;background-color: transparent"> <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;"> <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #ffffff;"><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--> <div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--> <table id="u_content_text_3" style="font-family:'."'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <div class="v-font-size" style="color: #27187e; line-height: 200%; text-align: center; word-wrap: break-word;"> <p style="font-size: 14px; line-height: 200%;"><span style="font-size: 18px; line-height: 36px;"><strong>'.'</strong></span></p> <p style="font-size: 14px; line-height: 200%;"><span style="font-size: 18px; line-height: 36px;"><strong>'.$rendezVou->getDateRendezVous()->format('l j F Y')." à ".$rendezVou->getHeureRendezVous() .'</strong></span></p> </div> </td> </tr> </tbody> </table> <table style="font-family:'."'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:15px 10px 30px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <!--[if mso]><style>.v-button {background: transparent !important;}</style><![endif]--> <div align="center"> <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://unlayer.com" style="height:49px; v-text-anchor:middle; width:170px;" arcsize="0%"  stroke="f" fillcolor="#843fa1"><w:anchorlock/><center style="color:#FFFFFF;font-family:'."'Montserrat'".',sans-serif;"><![endif]--> <a href="http://localhost:8000/" target="_blank" class="v-button v-font-size" style="box-sizing: border-box;display: inline-block;font-family:'."'Montserrat'".',sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #843fa1; border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;"> <span style="display:block;padding:16px 50px;line-height:120%;">Visiter notre site</span> </a> <!--[if mso]></center></v:roundrect><![endif]--> </div> </td> </tr> </tbody> </table> <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--> </div> </div> <!--[if (mso)|(IE)]></td><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--> <div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--> <table style="font-family:'."'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:15px 10px 0px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <h4 class="v-font-size" style="margin: 0px; color: #27187e; line-height: 140%; text-align: left; word-wrap: break-word; font-family: arial,helvetica,sans-serif; font-size: 18px; "><strong>Noublier pas </strong></h4> </td> </tr> </tbody> </table> <table style="font-family:'."'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px 30px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <div class="v-font-size" style="line-height: 180%; text-align: left; word-wrap: break-word;"> <ul style="list-style-type: circle;"> <li style="font-size: 14px; line-height: 25.2px;">d etre present au a la date mentione si non votre candidatures est considere comme refuser</li><img src="cid:qr_code.png" alt="QR Code"><li style="font-size: 14px; line-height: 25.2px;">'." N'oublier pas d'apporter votre CV".',</li> </ul> </div> </td> </tr> </tbody> </table> <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--> </div> </div> <!--[if (mso)|(IE)]></td><![endif]--> <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--> </div> </div> </div><div class="u-row-container" style="padding: 0px;background-color: transparent"> <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;"> <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"> <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]--> <!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--> <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;"> <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"> <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--> <table style="font-family:'."'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"> <tbody> <tr> <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:0px 0px 20px;font-family:'."'Montserrat'".',sans-serif;" align="left"> <table width="100%" cellpadding="0" cellspacing="0" border="0"> <tr> <td style="padding-right: 0px;padding-left: 0px;" align="center"> <img align="center" border="0" src="https://scontent.ftun6-1.fna.fbcdn.net/v/t1.15752-9/338387004_1221219468763000_7735201454890114311_n.png?_nc_cat=101&ccb=1-7&_nc_sid=ae9488&_nc_ohc=TRkRfaB6WMwAX_Oaw75&_nc_ht=scontent.ftun6-1.fna&oh=03_AdQLvbx4poUnRpETm_A3w85bDh0ziaZWQ39bMxP2ewOl3Q&oe=6463CB9A" alt="border" title="border" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 600px;" width="600" class="v-src-width v-src-max-width"/> </td> </tr> </table> </td> </tr> </tbody> </table> <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--> </div> </div> <!--[if (mso)|(IE)]></td><![endif]--> <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--> </div> </div> </div> <div class="u-row-container" style="padding: 0px;background-color: transparent"><div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;"><!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]--><!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]--><div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;"><div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]--><table style="font-family'.":'Montserrat'".',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family'.":'Montserrat'".',sans-serif;" align="left"><table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%"><span>&#160;</span></td></tr></tbody></table></td></tr></tbody></table><!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>');

            $this->mailer->send($email);

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            "candidature"=>$Candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{idRendezVous}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vous' => $rendezVou,
        ]);
    }

    #[Route('/{idRendezVous}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {

        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rendezVousRepository->save($rendezVou, true);

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{idRendezVous}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request,ManagerRegistry $doctrine, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        $entityManager = $doctrine->getManager();
        $postulation = $entityManager->getRepository(Postulation::class)->findOneBy([
            'userPostulation' => $rendezVou->getUserRendezVous(),
            'annoncePostulation' => $rendezVou->getAnnonceAssocierRendezVous(),
        ]);
        // Update the entity properties
        $postulation->setEtat('refuser');
        $entityManager->flush();
       // if ($this->isCsrfTokenValid('delete'.$rendezVou->getIdRendezVous(), $request->request->get('_token'))) {
            $rendezVousRepository->remove($rendezVou, true);
     //   }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
