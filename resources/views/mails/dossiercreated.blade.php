<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Nouveau dossier crée</title>

    <link rel="stylesheet" type="text/css" href="stylesheets/email.css" />

</head>

<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#999999">
    <tr>
        <td></td>
        <td class="header container" >

            <div class="content">
                <table bgcolor="#999999">
                    <tr>
                        <td>Part Pro Finance</td>
                    </tr>
                </table>
            </div>

        </td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td><h1>Nouveau Dossier</h1></td>
    </tr>
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table>
                    <tr>
                        <td>
                            Nom : <b>{{ $dossier->user->prospect->nom }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Prenom : <b>{{ $dossier->user->prospect->prenom }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Téléphone : <b>{{ $dossier->user->prospect->numTelPortable }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email Client : <b>{{ $dossier->user->email }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Iban Client : <b>{{ $dossier->user->prospect->iban }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Signature Electronique : <b>{{ $dossier->user->prospect->mandat_status ? 'oui' : 'non' }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Numéro de dossier : <b>{{ $dossier->num_dossier_banque }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date de Naissance : <b>{{ $dossier->user->prospect->dateDeNaissance }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ville & Département : <b>{{ $dossier->user->prospect->codePostal }} - {{ $dossier->user->prospect->ville }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Commission TTC : <b>{{ $dossier->montant_commission_partpro }} €</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Commission HT : <b>{{ $dossier->montant_commission_partpro / 1.2 }} €</b>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->
        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

</body>
</html>