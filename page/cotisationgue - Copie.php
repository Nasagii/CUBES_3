<?php
function download($file)
{
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "Le fichier demandé n'a pas été trouvé.";
    }
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    download($file);
}
?>

<div class="main">
    <main class="coti">
        <section>
            <h1>Informations</h1>
            <p class="important">Si vous recevez ce mail, ce n’est que vous n’êtes pas à jour de votre cotisation :</p>
            <ol>
                <li class="italique">Vous n’êtes pas couvert par notre assurance.</li>
                <li class="italique">Vous n’avez pas le droit de vote à l’AG</li>
                <li class="italique">Vous faites du bénévolat de façon illégale puisque votre adhésion n’est plus à jour. Article 2.2 la charte</li>
                <li class="italique">Attention le tarif est de minimum 25 € pour l’année.</li>
            </ol>
   
            <div class="pdf-container">
                <a class="link" href="pdf/Adhesion-et-re-adhesion-2023-2024.pdf" target="_blank">Adhésion et re-adhésion 2023/2024</a>
                <a class="DLbutton" href="?file=pdf/Adhesion-et-re-adhesion-2023-2024.pdf">Télécharger</a>
            
            <embed src="pdf/Adhesion-et-re-adhesion-2023-2024.pdf" width=800 height=500 type='application/pdf'/>
            </div>
            <div class="pdf-container">
                <a class="link" href="pdf/Bulletin-dAdhesion-SPA-Salon-2022.pdf" target="_blank">Bulletin d'adhésion SPA Salon 2022</a>
                <a class="DLbutton" href="?file=pdf/Bulletin-dAdhesion-SPA-Salon-2022.pdf">Télécharger</a>
            
            <embed src="pdf/Bulletin-dAdhesion-SPA-Salon-2022.pdf" width=800 height=500 type='application/pdf'/>
            </div>
            <div class="pdf-container">
                <a class="link" href="pdf/Rapport-dactivites-SPA-Salon-et-sa-Region-2021-au-24-03-22.pdf" target="_blank">Rapport d’activités SPA Salon et sa Région 2021 au 24-03-22</a>
                <a class="DLbutton" href="?file=pdf/Rapport-dactivites-SPA-Salon-et-sa-Region-2021-au-24-03-22.pdf">Télécharger</a>
            
            <embed src="pdf/Rapport-dactivites-SPA-Salon-et-sa-Region-2021-au-24-03-22.pdf" width=800 height=500 type='application/pdf'/>
            </div>
            <p class="italique" style="text-transform: uppercase;">VOUS POUVEZ RÉGLER VOTRE COTISATION PAR CHÈQUE ; PAYPAL OU VIREMENT. NOUS VOUS REMERCIONS PAR AVANCE.</p>
            <table>
                <tr>
                    <th>Par chèque</th>
                    <th>Par virement</th>
                </tr>
                <tr>
                    <td data-label="Par chèque">à l'ordre de la S.P.A de Salon<br>Merci de nous rappeler votre adresse mail</td>
                    <td data-label="Par virement">IBAN : FR76 1027 8089 8500 0209 4060 176<br>BIC-ADRESSE SWIFT : CMCIFR2A</td>
                </tr>
            </table>
            <p class="paypal">PAR PAYPAL caca prout :</p>
            <a class="link" href="https://www.paypal.com/donate?token=EUAabi3HLySIgHj_-mTGnVRTb8rMqAtrQ3IKtLzn6QhYPgO_F1SZfb1UbteW4vyEWW2guEDYezwltwCm" target="_blank">Lien Paypal</a>
            <p class="coordonnees" style="text-transform: uppercase;">POUR LES COTISATIONS ET VOS DONS, METTRE TOUTES VOS COORDONNÉES, MERCI.<br>POUR LES C.E.R.F.A PAR MAIL ET NE PAS OUBLIER DE REGARDER AUSSI DANS LES SPAMS EN PARTICULIERS POUR LES ADRESSES GMAIL.COM</p>
        </section>
    </main>
</div>