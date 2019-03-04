@php
    $formatter = \NumberFormatter::create('fr_FR', \NumberFormatter::SPELLOUT);
    $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
    $formatter->setAttribute(\NumberFormatter::ROUNDING_MODE, \NumberFormatter::ROUND_HALFUP);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>

        @page {
            size: 21cm 29.7cm;
            margin: 10mm 10mm 10mm 10mm;
        }

        .page-break {
            page-break-after: always;
        }

        .mandatcontainer{
            font-family:Calibri; background-color: white; padding: 20px;
            background-color: white;
        }

        table .data{ background-color: #CCCCCC; text-transform: uppercase; border: 1px dotted black; padding-left: 10px;}
        table th.signature{ background-color: #CCC;  border: 1px solid black; vertical-align: text-top; padding: 10px 0 0 10px;}

        .a4{border: 1px solid blue;}
        .mandatcontainer h5{ text-decoration: underline; font-weight: bolder; text-align: center;}
        .table-mandat{ width: 100%}
        .page-break {  page-break-after: always;}
    </style>
</head>
<body>
    <div class="mandatcontainer">
        <div class="header">
                <img src="{{ public_path('img/header-mandat.png')}}" class="img-responsive" width="100%">
        </div>
        <h4><u>ENTRE LES SOUSSIGNES :</u></h4>
        <div>
                <p>
                    <b>{{ $prospect->civilite }} {{ strtoupper($prospect->nom) }} {{ strtoupper($prospect->prenom) }}</b>
                    <br>
                    Demeurant : {{ $prospect->adresse  }}, {{ $prospect->codePostal}} {{ $prospect->ville }}<br>
                    Ci-après dénommé (e) (s) : « Le Mandant »<br>
                    <b>Et : </b><br>
                    La société <b>MBCFINANCES</b> (Sarl Rachat de Crédits et Prêts), immatriculée au RCS de Mulhouse, sous le
                    numéro 509661252, dont le siège social est situé 6 rue de la Couronne 68730 Blotzheim et inscrite à
                    l’ORIAS sous le numéro 09050788 en tant que Courtier en Opérations de Banque , Mandataire
                    d’intermédiaire en Opération de Banques et Courtier en Assurance.
                    Téléphone : 04.89.68.41.02 ou les 06.15.80.55.66 / 06.22.03.69.89 / 06.46.45.80.35
                </p>
                <p>
                    Ci-après dénommée : <b>« Le Mandataire »</b>
                </p>
            </div>
        <h5 class="text-center">IL EST CONVENU CE QUI SUIT :</h5>
        <div>
                <p>
                    <i>« Le Mandant »</i> confère par les présentes au <i>« Mandataire »</i>,
                    qui accepte, mandat d’effectuer les études, démarches et négociations,
                    auprès de tout organisme au choix du Mandataire, aux fins d’obtention
                    d’un prêt répondant si possible aux caractéristiques suivantes :
                </p>
                <p>
                Montant envisagé : {{ $zeDossier->montant_final }} EUROS<br><br>

                Montant en lettre :  {{ strtoupper( $formatter->format($zeDossier->montant_final) ) }} EUROS<br><br>

                Durée envisagée : {{ $zeDossier->duree_du_pret }} mois<br><br>

                Objet du prêt : PRÊT PERSONNEL<br><br>
                </p>
                <p>
                    Il est précisé toutefois que le Mandataire a la possibilité de modifier les caractéristiques
                    du prêt envisagé, afin de servir au mieux les intérêts du Mandant et sans qu’il soit nécessaire
                    d’établir un nouveau mandat de recherche aux fins d’obtention d’un prêt.
                </p>
            </div>
        <h5 class="text-center">OBLIGATIONS DU MANDANT :</h5>
        <div>
            <p>
                Le Mandant doit fournir au Mandataire tous renseignements ou
                documents qui lui sont demandés pour la constitution de son dossier,
                en vue de permettre de mener à bien le présent mandat dont il est chargé.
            </p>
            <p>
                En aucun cas, le Mandataire ne pourra assurer la gestion des dettes
                du Mandant et ce, en application des dispositions de l’article L 342-1
                du Code de la Consommation, ni effectuer des opérations de  courtage
                financier en application des dispositions des articles 519-1 et 519-2 du Code Monétaire et Financier.
            </p>
            <p>
                Le Mandant doit signaler immédiatement au Mandataire toutes
                informations complémentaires dont il a connaissance, ou toutes
                modifications juridiques ou matérielles, pouvant amener à modifier ledit dossier.
            </p>
            <p>
                Le Mandant reconnaît et accepte, qu’en cas de déclaration incomplète,
                erronée ou mensongère (par exemple : découvert bancaire ou prêt  en  cours  non  mentionné,
                interdiction  bancaire  ou  inscription  au  FICP  « Fichier  des  Incidents
                de remboursements des Crédits aux Particuliers », retrait de carte bancaire
                ou de chéquier non signalé, mise en règlement judiciaire ou en liquidation non mentionnée,
                fourniture de documents faux ou falsifiés,…etc.), la prestation du Mandataire
                est immédiatement interrompue et celui-ci se réserve la possibilité
                de poursuivre le Mandant en justice aux fins de solliciter des dommages-intérêts
                pour le préjudice subi par le Mandataire.
            </p>
        </div>
        <h5 class="text-center">OBLIGATIONS DU MANDANTAIRE :</h5>
        <div>
            <p>
                Le Mandant s’engage à verser au Mandataire, aux titres de frais
                de dossiers une somme égale à {{ $zeDossier->taux_commission }} %
                du montant effectivement prêté par la banque émettrice du crédit,
                encaissable exclusivement lorsque le financement sera accordé
                (soit {{ $prospect->dossiers->first()->taux_commission }} %) et le prêt mis en place
                (en application des articles L 341-1 et L 341-2 du Code Monétaire et Financier).
            </p>
            <p>
                Le Mandant s’engage ainsi à verser au Mandataire la somme de {{ $zeDossier->montant_commission_partpro }} EUROS
            </p>
            <p>
            La rémunération du mandataire s’effectuera par prélèvement SEPA,
                en exécution du Mandat de prélèvement SEPA joint aux présentes,
                et ce dans un délai maximum de huit jours après la réception des fonds sur le compte du Mandant.
            </p>
            <p>
                <b>
                    En outre, il est bien convenu, qu’en cas de refus de prêt,
                    le Mandataire ne pourra prétendre à aucune rémunération, qu’elle soit, de la part du Mandant.
                </b>
            </p>
            <p>
                Par la même, le Mandant reconnaît qu’il ne lui a été demandé aucune somme d’argent pour l’étude de son dossier.
            </p>
        </div>
        <div>
            <p>
                « Aucun versement de quelque nature que ce soit ne peut être exigé d’un particulier avant l’obtention
                d’un ou de plusieurs prêts d’argent ». Article L. 322-2 du Code de la consommation.
            </p>
            <p>
                Un crédit vous engage et doit être remboursé.
            </p>
            <p>
                Vérifiez votre capacité d’endettement avant de vous engager.
            </p>
            <p>
                Vous disposez d’un délai de rétractation de 14 jours suivant la signature de votre contrat pour renoncer à votre crédit.
            </p>
            <p>
                La baisse de la mensualité entraîne l’allongement de la durée de remboursement.
                Elle doit s’apprécier par rapport à la durée restant à courir des prêts objets du regroupement.
            </p>
            <p>
                Vous pouvez vous opposer sans frais à ce que vos données personnelles soient utilisées
                à des fins de sollicitations commerciales en écrivant à : DESCOLO – Service réclamation – 2721, Chemin de St Claude 06600 ANTIBES.
            </p>
            <p>
                Vous pouvez signaler toute réclamation auprès de l’ACPR 61 Rue Taitbout 75009 PARIS.
            </p>
        </div>
        <h5 class="text-center">***</h5>
        <div>
            <p>
                Le  présent Mandat est établi  en deux exemplaires dont un est remis au Mandant.
            </p>
            <p>
                Il est résilié automatiquement  après  l’octroi  du  prêt et paiement du Mandataire.
            </p>
            <p>
            Le Mandant et le Mandataire  s’engagent à  respecter  scrupuleusement la
                présente convention et à lui conserver une totale confidentialité.
            </p>
        </div>
        <h5>Fait à BLOTZHEIM, le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h5>
        <div class="row">
            <table class="table-mandat">
                <tr>
                    <th class="tg-0lax" style="width: 25%">Le MANDANT</th>
                    <th style="width: 40%"></th>
                    <th class="tg-0lax" style="width: 35%">Le MANDATAIRE</th>
                </tr>
                <tr>
                    <td class="tg-0lax">Signature</td>
                    <td></td>
                    <td class="tg-0lax">Représenté par Monsieur Frédéric BEAUDET, Gérant</td>
                    <td><img src="{{ asset('img/tampon_mbc_finances.png') }}" height="30px"></td>
                </tr>
                <tr>
                    <td class="tg-0lax">Lu et approuvé. Bon pour mandat.</td>
                    <td></td>
                    <td class="tg-0lax">Lu et approuvé. Bon pour acceptation de mandat.</td>
                </tr>
                <tr>
                    <td class="tg-0lax"></td>
                    <td class="tg-0lax"></td>
                </tr>
            </table>
        </div>
        <br>
        <div class="page-break"></div>
        <div class="header">
            <img src="{{ public_path('img/header-mandat.png')}}" class="img-responsive" width="100%">
        </div>
        <div style="padding-top: 10px;">
            <div class="text-center">Référence Unique de Mandat (RUM) : <b>2015DESCO11007</b><br></div>
            <b><u>En signant ce formulaire de mandat, vous autorisez :</u></b><br>
            - le créancier à envoyer des instructions à votre banque pour débiter votre compte,<br>
            - votre banque à débiter votre compte conformément aux instructions du créancier.</br>
            Vous bénéficiez du droit d’être remboursé par votre banque selon les conditions décrites dans la convention que vous avez passée avec elle. Une demande de remboursement doit être présentée dans les 8 semaines suivant la date de débit de votre compte pour un prélèvement autorisé.
            Veuillez vérifier et/ou compléter les champs marqués *.
        </div>
        <div style="padding-top: 10px;">
            <b>Vos informations</b>
            <table style="width: 600px">
                <thead>
                    <th style="width: 50%"></th><th style="width: 50%"></th>
                </thead>
                <tbody>
                    <tr></tr>
                    <tr>
                        <td>Nom – Prénom(s)* :</td>
                        <td class="data">{{ strtoupper($prospect->nom) }} {{ strtoupper($prospect->prenom) }}</td>
                    </tr>
                    <tr>
                    <td>Adresse* :</td>
                    <td class="data"> {{ $prospect->adresse }}</td>
                </tr>
                    <tr>
                    <td>Code postal* :</td>
                    <td class="data"> {{ $prospect->codePostal }}</td>
                </tr>
                    <tr>
                    <td>Ville* :</td>
                    <td class="data"> {{ $prospect->ville }}</td>
                </tr>
                    <tr>
                    <td>Pays* : </td>
                    <td class="data">France</td>
                </tr>
                    <tr>
                    <td>
                        IBAN* :<br>
                        <span style="font-size: 8px; font-style: italic">N° d’identification international du compte bancaire<br>
                            (International Bank Account Number)</span>
                    </td>
                    <td class="data">{{ $prospect->iban }}</td>
                </tr>
                    <tr>
                    <td>BIC* :</td>
                    <td class="data"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding-top: 10px;">
            <b>Votre créancier</b>
            <table style="width: 600px">
                <thead><tr><th style="width: 50%"></th><th style="width: 50%"></th></tr></thead>
                <tbody>
                <tr>
                    <td>Identifiant Créancier SEPA (ICS) :</td>
                    <td><b>FR19ZZZ805C50</b></td>
                </tr>
                <tr>
                    <td>Nom du créancier :</td>
                    <td>SASU DESCOLO</td>
                </tr>
                <tr>
                    <td>Adresse :</td>
                    <td>2721 Chemin de Saint Claude - 06600 ANTIBES
                    </td>
                </tr>
                <tr>
                    <td>Pays : </td>
                    <td>FRANCE</td>
                </tr>
             </tbody>
            </table>
        </div>
        <div style="padding-top: 10px;">
            <table style="width: 600px">
                <tr>
                    <th style="width:25%"><u>Type de paiement :</u></th>
                    <th style="width:25%"><b>Paiement Unique</b></th>
                    <th style="width:50%" rowspan="3" class="signature">
                        Fait à : ANTIBES  Date : {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                        Signature de l'emprunteur:<br>
                    </th>
                </tr>
                <tr>
                    <td class="tg-0pky" colspan="2">
                        <u>Note :</u><br>
                        Vos droits concernant le présent mandat sont expliqués dans un document que vous pouvez obtenir auprès de votre banque.
                    </td>
                </tr>
                <tr>
                    <td class="tg-0pky" colspan="2">
                        <u>Adresse de renvoi : </u><br>
                        DESCOLO<br> 2721 Chemin de Saint Claude 06600 ANTIBES
                    </td>
                </tr>
            </table>
        </div>
        <div style="padding-top: 10px;">
            <p>
                Les informations contenues dans le présent mandat, qui doit être complété,
                sont obligatoires et destinées à n’être utilisées par le créancier que pour
                la gestion de sa relation avec le débiteur. Elles pourront donner lieu à
                l’exercice, par ce dernier, de ses droits d’opposition, d’accès et de
                rectification tels que prévus aux articles 38 et suivants de la loi
                n°78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers
                et libertés, en écrivant au Service Consommateur du créancier.
            </p>
        </div>
    </div>
</body>
</html>