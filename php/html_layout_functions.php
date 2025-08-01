<?php
$view = "";

function getcombo_devise($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_devise");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['abreviation'] == $choosed) {

            $content = $content . '<option value="' . $result['abreviation'] . '" selected>' . $result['abreviation'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['abreviation'] . '">' . $result['abreviation'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_agence($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_agence");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['id_agence'] == $choosed) {

            $content = $content . '<option value="' . $result['id_agence'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['id_agence'] . '">' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_user($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_user order by username asc");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['iduser'] == $choosed) {

            $content = $content . '<option value="' . $result['iduser'] . '" selected>' . $result['username'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['iduser'] . '">' . $result['username'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_username($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_user order by username asc");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['username'] == $choosed) {

            $content = $content . '<option value="' . $result['username'] . '" selected>' . $result['username'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['username'] . '">' . $result['username'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_agence_titre($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_agence");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['id_agence'] == $choosed) {

            $content = $content . '<option value="' . $result['id_agence'] . '" selected>' . $result['label'] . ' - 1$:' . $_SESSION['my_taux'] . 'Fc</option>';
        } else {

            $content = $content . '<option value="' . $result['id_agence'] . '">' . $result['label'] . ' - 1$:' . $_SESSION['my_taux'] . 'Fc</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_pays_bd($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_pays");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['label'] == $choosed) {

            $content = $content . '<option value="' . $result['label'] . '" selected>' . $result['label'] . 'Fc</option>';
        } else {

            $content = $content . '<option value="' . $result['label'] . '">' . $result['label'] . ' </option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_statut_dossier($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select t.* from t_statut_dossier t join t_statu_dossier_profile on ref_statut_dossier=idt_statut_dossier where ref_profile=" . $_SESSION['my_idprofile']);

    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['label'] == $choosed) {

            $content = $content . '<option value="' . $result['label'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['label'] . '">' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_restric_statut_dossier($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select t.* from t_statut_dossier t join t_statu_dossier_profile on ref_statut_dossier=idt_statut_dossier where ref_profile=" . $_SESSION['my_idprofile']);

    while ($result = $sql_query->fetch()) {


        $content = $content . '<textarea name="dos_statut_sms" class="form-control" value="' . $result['label'] . '">' . $result['label'] . '</textarea>';
    }


    $content = $content;
    return $content;
}

function getcombo_statut_modul_souht($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select * from t_parametre where titre='module_souhait_statut' ");

    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['valeur'] == 'activer') {

            $content = $content . '<input type="hidden" name="idt_mdl_sht" value="' . $result['idt_parametre'] . '">
            <select name="mdl_sht" class="form-control select2">
            <option value="">-------------Choisir---------------</option>
            <option value="' . $result['valeur'] . '" selected>' . $result['valeur'] . '(Actuel)</option>
            <option value="desactiver">Desactiver</option>
            </select>
            ';
        } else {

            $content = $content . '<input type="hidden" name="idt_mdl_sht" value="' . $result['idt_parametre'] . '">
            <select name="mdl_sht" class="form-control select2">
            <option value="">-------------Choisir---------------</option>
            <option value="' . $result['valeur'] . '" selected>' . $result['valeur'] . ' (Actuel) </option>
            <option value="activer">Activer</option>
            </select>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_operation_paiement($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("SELECT t.* FROM passport_bd.t_operation t    where groupement = 'Paiement' group by t.idt_operation");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '">' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_operation_paiement_dossier($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("SELECT t.* FROM passport_bd.t_operation t join t_ecriture on ref_operation=t.idt_operation   where groupement = 'Paiement' and customer_viewable=1 group by t.idt_operation");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '">' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function get_combo_quiz()
{


    echo '
            <option value=""></option>
            <option value="0">NON</option>
            <option value="1">OUI</option>
    ';

    /*if(isset($_GET['quiz_client']) && $_GET['quiz_client'] == 0)
    {
        echo '<option value="Non">Non</option>';
    }else{

        echo "
                <div class='form-group'>
                      <label  class='col-sm-6 control-label'>Pays et Université<font color='#FF0000'>*</font></label>
                      <div class='col-sm-6'>
                        <input type='text' name='quiz_university' class='form-control'  placeholder='Citez le pays et l'université' required='true'>
                      </div>
                </div>

        ";
    }*/
}

function get_combo_liste_pays()
{

    echo '


<option value="Afghanistan">Afghanistan </option>
<option value="Afrique_Centrale">Afrique_Centrale </option>
<option value="Afrique_du_sud">Afrique_du_Sud </option> 
<option value="Albanie">Albanie </option>
<option value="Algerie">Algerie </option>
<option value="Allemagne">Allemagne </option>
<option value="Andorre">Andorre </option>
<option value="Angola">Angola </option>
<option value="Anguilla">Anguilla </option>
<option value="Arabie_Saoudite">Arabie_Saoudite </option>
<option value="Argentine">Argentine </option>
<option value="Armenie">Armenie </option> 
<option value="Australie">Australie </option>
<option value="Autriche">Autriche </option>
<option value="Azerbaidjan">Azerbaidjan </option>

<option value="Bahamas">Bahamas </option>
<option value="Bangladesh">Bangladesh </option>
<option value="Barbade">Barbade </option>
<option value="Bahrein">Bahrein </option>
<option value="Belgique">Belgique </option>
<option value="Belize">Belize </option>
<option value="Benin">Benin </option>
<option value="Bermudes">Bermudes </option>
<option value="Bielorussie">Bielorussie </option>
<option value="Bolivie">Bolivie </option>
<option value="Botswana">Botswana </option>
<option value="Bhoutan">Bhoutan </option>
<option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
<option value="Bresil">Bresil </option>
<option value="Brunei">Brunei </option>
<option value="Bulgarie">Bulgarie </option>
<option value="Burkina_Faso">Burkina_Faso </option>
<option value="Burundi">Burundi </option>

<option value="Caiman">Caiman </option>
<option value="Cambodge">Cambodge </option>
<option value="Cameroun">Cameroun </option>
<option value="Canada" selected>Canada </option>
<option value="Canaries">Canaries </option>
<option value="Cap_vert">Cap_Vert </option>
<option value="Chili">Chili </option>
<option value="Chine">Chine </option> 
<option value="Chypre">Chypre </option> 
<option value="Colombie">Colombie </option>
<option value="Comores">Colombie </option>
<option value="Congo">Congo </option>
<option value="Congo_democratique">Congo_democratique </option>
<option value="Cook">Cook </option>
<option value="Coree_du_Nord">Coree_du_Nord </option>
<option value="Coree_du_Sud">Coree_du_Sud </option>
<option value="Costa_Rica">Costa_Rica </option>
<option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
<option value="Croatie">Croatie </option>
<option value="Cuba">Cuba </option>

<option value="Danemark">Danemark </option>
<option value="Djibouti">Djibouti </option>
<option value="Dominique">Dominique </option>

<option value="Egypte">Egypte </option> 
<option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
<option value="Equateur">Equateur </option>
<option value="Erythree">Erythree </option>
<option value="Espagne">Espagne </option>
<option value="Estonie">Estonie </option>
<option value="Etats_Unis">Etats_Unis </option>
<option value="Ethiopie">Ethiopie </option>
<option value="France" >France </option>
<option value="Falkland">Falkland </option>
<option value="Feroe">Feroe </option>
<option value="Fidji">Fidji </option>
<option value="Finlande">Finlande </option>
<option value="France">France </option>

<option value="Gabon">Gabon </option>
<option value="Gambie">Gambie </option>
<option value="Georgie">Georgie </option>
<option value="Ghana">Ghana </option>
<option value="Gibraltar">Gibraltar </option>
<option value="Grece">Grece </option>
<option value="Grenade">Grenade </option>
<option value="Groenland">Groenland </option>
<option value="Guadeloupe">Guadeloupe </option>
<option value="Guam">Guam </option>
<option value="Guatemala">Guatemala</option>
<option value="Guernesey">Guernesey </option>
<option value="Guinee">Guinee </option>
<option value="Guinee_Bissau">Guinee_Bissau </option>
<option value="Guinee equatoriale">Guinee_Equatoriale </option>
<option value="Guyana">Guyana </option>
<option value="Guyane_Francaise ">Guyane_Francaise </option>

<option value="Haiti">Haiti </option>
<option value="Hawaii">Hawaii </option> 
<option value="Honduras">Honduras </option>
<option value="Hong_Kong">Hong_Kong </option>
<option value="Hongrie">Hongrie </option>

<option value="Inde">Inde </option>
<option value="Indonesie">Indonesie </option>
<option value="Iran">Iran </option>
<option value="Iraq">Iraq </option>
<option value="Irlande">Irlande </option>
<option value="Islande">Islande </option>
<option value="Israel">Israel </option>
<option value="Italie">italie </option>

<option value="Jamaique">Jamaique </option>
<option value="Jan Mayen">Jan Mayen </option>
<option value="Japon">Japon </option>
<option value="Jersey">Jersey </option>
<option value="Jordanie">Jordanie </option>

<option value="Kazakhstan">Kazakhstan </option>
<option value="Kenya">Kenya </option>
<option value="Kirghizstan">Kirghizistan </option>
<option value="Kiribati">Kiribati </option>
<option value="Koweit">Koweit </option>

<option value="Laos">Laos </option>
<option value="Lesotho">Lesotho </option>
<option value="Lettonie">Lettonie </option>
<option value="Liban">Liban </option>
<option value="Liberia">Liberia </option>
<option value="Liechtenstein">Liechtenstein </option>
<option value="Lituanie">Lituanie </option> 
<option value="Luxembourg">Luxembourg </option>
<option value="Lybie">Lybie </option>

<option value="Macao">Macao </option>
<option value="Macedoine">Macedoine </option>
<option value="Madagascar">Madagascar </option>
<option value="Madère">Madère </option>
<option value="Malaisie">Malaisie </option>
<option value="Malawi">Malawi </option>
<option value="Maldives">Maldives </option>
<option value="Mali">Mali </option>
<option value="Malte">Malte </option>
<option value="Man">Man </option>
<option value="Mariannes du Nord">Mariannes du Nord </option>
<option value="Maroc">Maroc </option>
<option value="Marshall">Marshall </option>
<option value="Martinique">Martinique </option>
<option value="Maurice">Maurice </option>
<option value="Mauritanie">Mauritanie </option>
<option value="Mayotte">Mayotte </option>
<option value="Mexique">Mexique </option>
<option value="Micronesie">Micronesie </option>
<option value="Midway">Midway </option>
<option value="Moldavie">Moldavie </option>
<option value="Monaco">Monaco </option>
<option value="Mongolie">Mongolie </option>
<option value="Montserrat">Montserrat </option>
<option value="Mozambique">Mozambique </option>

<option value="Namibie">Namibie </option>
<option value="Nauru">Nauru </option>
<option value="Nepal">Nepal </option>
<option value="Nicaragua">Nicaragua </option>
<option value="Niger">Niger </option>
<option value="Nigeria">Nigeria </option>
<option value="Niue">Niue </option>
<option value="Norfolk">Norfolk </option>
<option value="Norvege">Norvege </option>
<option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
<option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

<option value="Oman">Oman </option>
<option value="Ouganda">Ouganda </option>
<option value="Ouzbekistan">Ouzbekistan </option>

<option value="Pakistan">Pakistan </option>
<option value="Palau">Palau </option>
<option value="Palestine">Palestine </option>
<option value="Panama">Panama </option>
<option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
<option value="Paraguay">Paraguay </option>
<option value="Pays_Bas">Pays_Bas </option>
<option value="Perou">Perou </option>
<option value="Philippines">Philippines </option> 
<option value="Pologne">Pologne </option>
<option value="Polynesie">Polynesie </option>
<option value="Porto_Rico">Porto_Rico </option>
<option value="Portugal">Portugal </option>

<option value="Qatar">Qatar </option>

<option value="Republique_Dominicaine">Republique_Dominicaine </option>
<option value="Republique_Tcheque">Republique_Tcheque </option>
<option value="Reunion">Reunion </option>
<option value="Roumanie">Roumanie </option>
<option value="Royaume_Uni">Royaume_Uni </option>
<option value="Russie">Russie </option>
<option value="Rwanda">Rwanda </option>

<option value="Sahara Occidental">Sahara Occidental </option>
<option value="Sainte_Lucie">Sainte_Lucie </option>
<option value="Saint_Marin">Saint_Marin </option>
<option value="Salomon">Salomon </option>
<option value="Salvador">Salvador </option>
<option value="Samoa_Occidentales">Samoa_Occidentales</option>
<option value="Samoa_Americaine">Samoa_Americaine </option>
<option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option> 
<option value="Senegal">Senegal </option> 
<option value="Seychelles">Seychelles </option>
<option value="Sierra Leone">Sierra Leone </option>
<option value="Singapour">Singapour </option>
<option value="Slovaquie">Slovaquie </option>
<option value="Slovenie">Slovenie</option>
<option value="Somalie">Somalie </option>
<option value="Soudan">Soudan </option> 
<option value="Sri_Lanka">Sri_Lanka </option> 
<option value="Suede">Suede </option>
<option value="Suisse">Suisse </option>
<option value="Surinam">Surinam </option>
<option value="Swaziland">Swaziland </option>
<option value="Syrie">Syrie </option>

<option value="Tadjikistan">Tadjikistan </option>
<option value="Taiwan">Taiwan </option>
<option value="Tonga">Tonga </option>
<option value="Tanzanie">Tanzanie </option>
<option value="Tchad">Tchad </option>
<option value="Thailande">Thailande </option>
<option value="Tibet">Tibet </option>
<option value="Timor_Oriental">Timor_Oriental </option>
<option value="Togo">Togo </option> 
<option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
<option value="Tristan da cunha">Tristan de cuncha </option>
<option value="Tunisie">Tunisie </option>
<option value="Turkmenistan">Turmenistan </option> 
<option value="Turquie">Turquie </option>

<option value="Ukraine">Ukraine </option>
<option value="Uruguay">Uruguay </option>

<option value="Vanuatu">Vanuatu </option>
<option value="Vatican">Vatican </option>
<option value="Venezuela">Venezuela </option>
<option value="Vierges_Americaines">Vierges_Americaines </option>
<option value="Vierges_Britanniques">Vierges_Britanniques </option>
<option value="Vietnam">Vietnam </option>

<option value="Wake">Wake </option>
<option value="Wallis et Futuma">Wallis et Futuma </option>

<option value="Yemen">Yemen </option>
<option value="Yougoslavie">Yougoslavie </option>

<option value="Zambie">Zambie </option>
<option value="Zimbabwe">Zimbabwe </option>
';
}
function get_combo_liste_pays_toutes()
{

    echo '


<option value="Afghanistan">Afghanistan </option>
<option value="Afrique_Centrale">Afrique_Centrale </option>
<option value="Afrique_du_sud">Afrique_du_Sud </option> 
<option value="Albanie">Albanie </option>
<option value="Algerie">Algerie </option>
<option value="Allemagne">Allemagne </option>
<option value="Andorre">Andorre </option>
<option value="Angola">Angola </option>
<option value="Anguilla">Anguilla </option>
<option value="Arabie_Saoudite">Arabie_Saoudite </option>
<option value="Argentine">Argentine </option>
<option value="Armenie">Armenie </option> 
<option value="Australie">Australie </option>
<option value="Autriche">Autriche </option>
<option value="Azerbaidjan">Azerbaidjan </option>

<option value="Bahamas">Bahamas </option>
<option value="Bangladesh">Bangladesh </option>
<option value="Barbade">Barbade </option>
<option value="Bahrein">Bahrein </option>
<option value="Belgique">Belgique </option>
<option value="Belize">Belize </option>
<option value="Benin">Benin </option>
<option value="Bermudes">Bermudes </option>
<option value="Bielorussie">Bielorussie </option>
<option value="Bolivie">Bolivie </option>
<option value="Botswana">Botswana </option>
<option value="Bhoutan">Bhoutan </option>
<option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
<option value="Bresil">Bresil </option>
<option value="Brunei">Brunei </option>
<option value="Bulgarie">Bulgarie </option>
<option value="Burkina_Faso">Burkina_Faso </option>
<option value="Burundi">Burundi </option>

<option value="Caiman">Caiman </option>
<option value="Cambodge">Cambodge </option>
<option value="Cameroun">Cameroun </option>
<option value="Canada">Canada </option>
<option value="Canaries">Canaries </option>
<option value="Cap_vert">Cap_Vert </option>
<option value="Chili">Chili </option>
<option value="Chine">Chine </option> 
<option value="Chypre">Chypre </option> 
<option value="Colombie">Colombie </option>
<option value="Comores">Colombie </option>
<option value="Congo">Congo </option>
<option value="Congo_democratique">Congo_democratique </option>
<option value="Cook">Cook </option>
<option value="Coree_du_Nord">Coree_du_Nord </option>
<option value="Coree_du_Sud">Coree_du_Sud </option>
<option value="Costa_Rica">Costa_Rica </option>
<option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
<option value="Croatie">Croatie </option>
<option value="Cuba">Cuba </option>

<option value="Danemark">Danemark </option>
<option value="Djibouti">Djibouti </option>
<option value="Dominique">Dominique </option>

<option value="Egypte">Egypte </option> 
<option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
<option value="Equateur">Equateur </option>
<option value="Erythree">Erythree </option>
<option value="Espagne">Espagne </option>
<option value="Estonie">Estonie </option>
<option value="Etats_Unis">Etats_Unis </option>
<option value="Ethiopie">Ethiopie </option>
<option value="France" >France </option>
<option value="Falkland">Falkland </option>
<option value="Feroe">Feroe </option>
<option value="Fidji">Fidji </option>
<option value="Finlande">Finlande </option>
<option value="France">France </option>

<option value="Gabon">Gabon </option>
<option value="Gambie">Gambie </option>
<option value="Georgie">Georgie </option>
<option value="Ghana">Ghana </option>
<option value="Gibraltar">Gibraltar </option>
<option value="Grece">Grece </option>
<option value="Grenade">Grenade </option>
<option value="Groenland">Groenland </option>
<option value="Guadeloupe">Guadeloupe </option>
<option value="Guam">Guam </option>
<option value="Guatemala">Guatemala</option>
<option value="Guernesey">Guernesey </option>
<option value="Guinee">Guinee </option>
<option value="Guinee_Bissau">Guinee_Bissau </option>
<option value="Guinee equatoriale">Guinee_Equatoriale </option>
<option value="Guyana">Guyana </option>
<option value="Guyane_Francaise ">Guyane_Francaise </option>

<option value="Haiti">Haiti </option>
<option value="Hawaii">Hawaii </option> 
<option value="Honduras">Honduras </option>
<option value="Hong_Kong">Hong_Kong </option>
<option value="Hongrie">Hongrie </option>

<option value="Inde">Inde </option>
<option value="Indonesie">Indonesie </option>
<option value="Iran">Iran </option>
<option value="Iraq">Iraq </option>
<option value="Irlande">Irlande </option>
<option value="Islande">Islande </option>
<option value="Israel">Israel </option>
<option value="Italie">italie </option>

<option value="Jamaique">Jamaique </option>
<option value="Jan Mayen">Jan Mayen </option>
<option value="Japon">Japon </option>
<option value="Jersey">Jersey </option>
<option value="Jordanie">Jordanie </option>

<option value="Kazakhstan">Kazakhstan </option>
<option value="Kenya">Kenya </option>
<option value="Kirghizstan">Kirghizistan </option>
<option value="Kiribati">Kiribati </option>
<option value="Koweit">Koweit </option>

<option value="Laos">Laos </option>
<option value="Lesotho">Lesotho </option>
<option value="Lettonie">Lettonie </option>
<option value="Liban">Liban </option>
<option value="Liberia">Liberia </option>
<option value="Liechtenstein">Liechtenstein </option>
<option value="Lituanie">Lituanie </option> 
<option value="Luxembourg">Luxembourg </option>
<option value="Lybie">Lybie </option>

<option value="Macao">Macao </option>
<option value="Macedoine">Macedoine </option>
<option value="Madagascar">Madagascar </option>
<option value="Madère">Madère </option>
<option value="Malaisie">Malaisie </option>
<option value="Malawi">Malawi </option>
<option value="Maldives">Maldives </option>
<option value="Mali">Mali </option>
<option value="Malte">Malte </option>
<option value="Man">Man </option>
<option value="Mariannes du Nord">Mariannes du Nord </option>
<option value="Maroc">Maroc </option>
<option value="Marshall">Marshall </option>
<option value="Martinique">Martinique </option>
<option value="Maurice">Maurice </option>
<option value="Mauritanie">Mauritanie </option>
<option value="Mayotte">Mayotte </option>
<option value="Mexique">Mexique </option>
<option value="Micronesie">Micronesie </option>
<option value="Midway">Midway </option>
<option value="Moldavie">Moldavie </option>
<option value="Monaco">Monaco </option>
<option value="Mongolie">Mongolie </option>
<option value="Montserrat">Montserrat </option>
<option value="Mozambique">Mozambique </option>

<option value="Namibie">Namibie </option>
<option value="Nauru">Nauru </option>
<option value="Nepal">Nepal </option>
<option value="Nicaragua">Nicaragua </option>
<option value="Niger">Niger </option>
<option value="Nigeria">Nigeria </option>
<option value="Niue">Niue </option>
<option value="Norfolk">Norfolk </option>
<option value="Norvege">Norvege </option>
<option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
<option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

<option value="Oman">Oman </option>
<option value="Ouganda">Ouganda </option>
<option value="Ouzbekistan">Ouzbekistan </option>

<option value="Pakistan">Pakistan </option>
<option value="Palau">Palau </option>
<option value="Palestine">Palestine </option>
<option value="Panama">Panama </option>
<option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
<option value="Paraguay">Paraguay </option>
<option value="Pays_Bas">Pays_Bas </option>
<option value="Perou">Perou </option>
<option value="Philippines">Philippines </option> 
<option value="Pologne">Pologne </option>
<option value="Polynesie">Polynesie </option>
<option value="Porto_Rico">Porto_Rico </option>
<option value="Portugal">Portugal </option>

<option value="Qatar">Qatar </option>

<option value="Republique_Dominicaine">Republique_Dominicaine </option>
<option value="Republique_Tcheque">Republique_Tcheque </option>
<option value="Reunion">Reunion </option>
<option value="Roumanie">Roumanie </option>
<option value="Royaume_Uni">Royaume_Uni </option>
<option value="Russie">Russie </option>
<option value="Rwanda">Rwanda </option>

<option value="Sahara Occidental">Sahara Occidental </option>
<option value="Sainte_Lucie">Sainte_Lucie </option>
<option value="Saint_Marin">Saint_Marin </option>
<option value="Salomon">Salomon </option>
<option value="Salvador">Salvador </option>
<option value="Samoa_Occidentales">Samoa_Occidentales</option>
<option value="Samoa_Americaine">Samoa_Americaine </option>
<option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option> 
<option value="Senegal">Senegal </option> 
<option value="Seychelles">Seychelles </option>
<option value="Sierra Leone">Sierra Leone </option>
<option value="Singapour">Singapour </option>
<option value="Slovaquie">Slovaquie </option>
<option value="Slovenie">Slovenie</option>
<option value="Somalie">Somalie </option>
<option value="Soudan">Soudan </option> 
<option value="Sri_Lanka">Sri_Lanka </option> 
<option value="Suede">Suede </option>
<option value="Suisse">Suisse </option>
<option value="Surinam">Surinam </option>
<option value="Swaziland">Swaziland </option>
<option value="Syrie">Syrie </option>

<option value="Tadjikistan">Tadjikistan </option>
<option value="Taiwan">Taiwan </option>
<option value="Tonga">Tonga </option>
<option value="Tanzanie">Tanzanie </option>
<option value="Tchad">Tchad </option>
<option value="Thailande">Thailande </option>
<option value="Tibet">Tibet </option>
<option value="Timor_Oriental">Timor_Oriental </option>
<option value="Togo">Togo </option> 
<option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
<option value="Tristan da cunha">Tristan de cuncha </option>
<option value="Tunisie">Tunisie </option>
<option value="Turkmenistan">Turmenistan </option> 
<option value="Turquie">Turquie </option>

<option value="Ukraine">Ukraine </option>
<option value="Uruguay">Uruguay </option>

<option value="Vanuatu">Vanuatu </option>
<option value="Vatican">Vatican </option>
<option value="Venezuela">Venezuela </option>
<option value="Vierges_Americaines">Vierges_Americaines </option>
<option value="Vierges_Britanniques">Vierges_Britanniques </option>
<option value="Vietnam">Vietnam </option>

<option value="Wake">Wake </option>
<option value="Wallis et Futuma">Wallis et Futuma </option>

<option value="Yemen">Yemen </option>
<option value="Yougoslavie">Yougoslavie </option>

<option value="Zambie">Zambie </option>
<option value="Zimbabwe">Zimbabwe </option>
';
}

function getcombo_operation_groupement($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("SELECT * FROM passport_bd.t_operation where groupement = '" . $choosed . "'");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '">' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_broad($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select name,idbroadcast from t_broadcast_list order by name desc");
    $select_na =    ($choosed == "NA") ? " selected " : "";
    $select_all = ($choosed == "All") ? " selected " : "";
    $content = $content . '<option value="NA" ' . $select_na . '>Aucun</option>';
    $content = $content . '<option value="All" ' . $select_all . '>Tous</option>';

    while ($result = $sql_query->fetch()) {
        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idbroadcast'] == $choosed) {

            $content = $content . '<option value="' . $result['idbroadcast'] . '" selected>' . $result['name'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idbroadcast'] . '">' . $result['name'] . '</option>';
        }
    }
    $content = $content;
    return $content;
}

function get_combo_liste_pays_rdc()
{

    echo '


<option value="Afghanistan">Afghanistan </option>
<option value="Afrique_Centrale">Afrique_Centrale </option>
<option value="Afrique_du_sud">Afrique_du_Sud </option> 
<option value="Albanie">Albanie </option>
<option value="Algerie">Algerie </option>
<option value="Allemagne">Allemagne </option>
<option value="Andorre">Andorre </option>
<option value="Angola">Angola </option>
<option value="Anguilla">Anguilla </option>
<option value="Arabie_Saoudite">Arabie_Saoudite </option>
<option value="Argentine">Argentine </option>
<option value="Armenie">Armenie </option> 
<option value="Australie">Australie </option>
<option value="Autriche">Autriche </option>
<option value="Azerbaidjan">Azerbaidjan </option>

<option value="Bahamas">Bahamas </option>
<option value="Bangladesh">Bangladesh </option>
<option value="Barbade">Barbade </option>
<option value="Bahrein">Bahrein </option>
<option value="Belgique">Belgique </option>
<option value="Belize">Belize </option>
<option value="Benin">Benin </option>
<option value="Bermudes">Bermudes </option>
<option value="Bielorussie">Bielorussie </option>
<option value="Bolivie">Bolivie </option>
<option value="Botswana">Botswana </option>
<option value="Bhoutan">Bhoutan </option>
<option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
<option value="Bresil">Bresil </option>
<option value="Brunei">Brunei </option>
<option value="Bulgarie">Bulgarie </option>
<option value="Burkina_Faso">Burkina_Faso </option>
<option value="Burundi">Burundi </option>

<option value="Caiman">Caiman </option>
<option value="Cambodge">Cambodge </option>
<option value="Cameroun">Cameroun </option>
<option value="Canada" selected>Canada </option>
<option value="Canaries">Canaries </option>
<option value="Cap_vert">Cap_Vert </option>
<option value="Chili">Chili </option>
<option value="Chine">Chine </option> 
<option value="Chypre">Chypre </option> 
<option value="Colombie">Colombie </option>
<option value="Comores">Colombie </option>
<option value="Congo">Congo </option>
<option value="Congo_democratique" selected >Congo_democratique </option>
<option value="Cook">Cook </option>
<option value="Coree_du_Nord">Coree_du_Nord </option>
<option value="Coree_du_Sud">Coree_du_Sud </option>
<option value="Costa_Rica">Costa_Rica </option>
<option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
<option value="Croatie">Croatie </option>
<option value="Cuba">Cuba </option>

<option value="Danemark">Danemark </option>
<option value="Djibouti">Djibouti </option>
<option value="Dominique">Dominique </option>

<option value="Egypte">Egypte </option> 
<option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
<option value="Equateur">Equateur </option>
<option value="Erythree">Erythree </option>
<option value="Espagne">Espagne </option>
<option value="Estonie">Estonie </option>
<option value="Etats_Unis">Etats_Unis </option>
<option value="Ethiopie">Ethiopie </option>
<option value="France" >France </option>
<option value="Falkland">Falkland </option>
<option value="Feroe">Feroe </option>
<option value="Fidji">Fidji </option>
<option value="Finlande">Finlande </option>
<option value="France">France </option>

<option value="Gabon">Gabon </option>
<option value="Gambie">Gambie </option>
<option value="Georgie">Georgie </option>
<option value="Ghana">Ghana </option>
<option value="Gibraltar">Gibraltar </option>
<option value="Grece">Grece </option>
<option value="Grenade">Grenade </option>
<option value="Groenland">Groenland </option>
<option value="Guadeloupe">Guadeloupe </option>
<option value="Guam">Guam </option>
<option value="Guatemala">Guatemala</option>
<option value="Guernesey">Guernesey </option>
<option value="Guinee">Guinee </option>
<option value="Guinee_Bissau">Guinee_Bissau </option>
<option value="Guinee equatoriale">Guinee_Equatoriale </option>
<option value="Guyana">Guyana </option>
<option value="Guyane_Francaise ">Guyane_Francaise </option>

<option value="Haiti">Haiti </option>
<option value="Hawaii">Hawaii </option> 
<option value="Honduras">Honduras </option>
<option value="Hong_Kong">Hong_Kong </option>
<option value="Hongrie">Hongrie </option>

<option value="Inde">Inde </option>
<option value="Indonesie">Indonesie </option>
<option value="Iran">Iran </option>
<option value="Iraq">Iraq </option>
<option value="Irlande">Irlande </option>
<option value="Islande">Islande </option>
<option value="Israel">Israel </option>
<option value="Italie">italie </option>

<option value="Jamaique">Jamaique </option>
<option value="Jan Mayen">Jan Mayen </option>
<option value="Japon">Japon </option>
<option value="Jersey">Jersey </option>
<option value="Jordanie">Jordanie </option>

<option value="Kazakhstan">Kazakhstan </option>
<option value="Kenya">Kenya </option>
<option value="Kirghizstan">Kirghizistan </option>
<option value="Kiribati">Kiribati </option>
<option value="Koweit">Koweit </option>

<option value="Laos">Laos </option>
<option value="Lesotho">Lesotho </option>
<option value="Lettonie">Lettonie </option>
<option value="Liban">Liban </option>
<option value="Liberia">Liberia </option>
<option value="Liechtenstein">Liechtenstein </option>
<option value="Lituanie">Lituanie </option> 
<option value="Luxembourg">Luxembourg </option>
<option value="Lybie">Lybie </option>

<option value="Macao">Macao </option>
<option value="Macedoine">Macedoine </option>
<option value="Madagascar">Madagascar </option>
<option value="Madère">Madère </option>
<option value="Malaisie">Malaisie </option>
<option value="Malawi">Malawi </option>
<option value="Maldives">Maldives </option>
<option value="Mali">Mali </option>
<option value="Malte">Malte </option>
<option value="Man">Man </option>
<option value="Mariannes du Nord">Mariannes du Nord </option>
<option value="Maroc">Maroc </option>
<option value="Marshall">Marshall </option>
<option value="Martinique">Martinique </option>
<option value="Maurice">Maurice </option>
<option value="Mauritanie">Mauritanie </option>
<option value="Mayotte">Mayotte </option>
<option value="Mexique">Mexique </option>
<option value="Micronesie">Micronesie </option>
<option value="Midway">Midway </option>
<option value="Moldavie">Moldavie </option>
<option value="Monaco">Monaco </option>
<option value="Mongolie">Mongolie </option>
<option value="Montserrat">Montserrat </option>
<option value="Mozambique">Mozambique </option>

<option value="Namibie">Namibie </option>
<option value="Nauru">Nauru </option>
<option value="Nepal">Nepal </option>
<option value="Nicaragua">Nicaragua </option>
<option value="Niger">Niger </option>
<option value="Nigeria">Nigeria </option>
<option value="Niue">Niue </option>
<option value="Norfolk">Norfolk </option>
<option value="Norvege">Norvege </option>
<option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
<option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

<option value="Oman">Oman </option>
<option value="Ouganda">Ouganda </option>
<option value="Ouzbekistan">Ouzbekistan </option>

<option value="Pakistan">Pakistan </option>
<option value="Palau">Palau </option>
<option value="Palestine">Palestine </option>
<option value="Panama">Panama </option>
<option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
<option value="Paraguay">Paraguay </option>
<option value="Pays_Bas">Pays_Bas </option>
<option value="Perou">Perou </option>
<option value="Philippines">Philippines </option> 
<option value="Pologne">Pologne </option>
<option value="Polynesie">Polynesie </option>
<option value="Porto_Rico">Porto_Rico </option>
<option value="Portugal">Portugal </option>

<option value="Qatar">Qatar </option>

<option value="Republique_Dominicaine">Republique_Dominicaine </option>
<option value="Republique_Tcheque">Republique_Tcheque </option>
<option value="Reunion">Reunion </option>
<option value="Roumanie">Roumanie </option>
<option value="Royaume_Uni">Royaume_Uni </option>
<option value="Russie">Russie </option>
<option value="Rwanda">Rwanda </option>

<option value="Sahara Occidental">Sahara Occidental </option>
<option value="Sainte_Lucie">Sainte_Lucie </option>
<option value="Saint_Marin">Saint_Marin </option>
<option value="Salomon">Salomon </option>
<option value="Salvador">Salvador </option>
<option value="Samoa_Occidentales">Samoa_Occidentales</option>
<option value="Samoa_Americaine">Samoa_Americaine </option>
<option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option> 
<option value="Senegal">Senegal </option> 
<option value="Seychelles">Seychelles </option>
<option value="Sierra Leone">Sierra Leone </option>
<option value="Singapour">Singapour </option>
<option value="Slovaquie">Slovaquie </option>
<option value="Slovenie">Slovenie</option>
<option value="Somalie">Somalie </option>
<option value="Soudan">Soudan </option> 
<option value="Sri_Lanka">Sri_Lanka </option> 
<option value="Suede">Suede </option>
<option value="Suisse">Suisse </option>
<option value="Surinam">Surinam </option>
<option value="Swaziland">Swaziland </option>
<option value="Syrie">Syrie </option>

<option value="Tadjikistan">Tadjikistan </option>
<option value="Taiwan">Taiwan </option>
<option value="Tonga">Tonga </option>
<option value="Tanzanie">Tanzanie </option>
<option value="Tchad">Tchad </option>
<option value="Thailande">Thailande </option>
<option value="Tibet">Tibet </option>
<option value="Timor_Oriental">Timor_Oriental </option>
<option value="Togo">Togo </option> 
<option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
<option value="Tristan da cunha">Tristan de cuncha </option>
<option value="Tunisie">Tunisie </option>
<option value="Turkmenistan">Turmenistan </option> 
<option value="Turquie">Turquie </option>

<option value="Ukraine">Ukraine </option>
<option value="Uruguay">Uruguay </option>

<option value="Vanuatu">Vanuatu </option>
<option value="Vatican">Vatican </option>
<option value="Venezuela">Venezuela </option>
<option value="Vierges_Americaines">Vierges_Americaines </option>
<option value="Vierges_Britanniques">Vierges_Britanniques </option>
<option value="Vietnam">Vietnam </option>

<option value="Wake">Wake </option>
<option value="Wallis et Futuma">Wallis et Futuma </option>

<option value="Yemen">Yemen </option>
<option value="Yougoslavie">Yougoslavie </option>

<option value="Zambie">Zambie </option>
<option value="Zimbabwe">Zimbabwe </option>
';
}


function getcombo_reference_capture($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select distinct libelle from t_capture_bilan");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['libelle'] == $choosed) {

            $content = $content . '<option value="' . $result['libelle'] . '" selected>' . $result['libelle'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['libelle'] . '" >' . $result['libelle'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_type_operation($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_type_operation where label<>'DOS'");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['id_type_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['label'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['label'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_compte($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_livre_compte where ref_agence=" . $_SESSION['my_agence']);


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['account_no'] == $choosed) {

            $content = $content . '<option value="' . $result['account_no'] . '" selected>' . $result['account_no'] . " - " . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['account_no'] . '" >' . $result['account_no'] . " - " . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_operation_comptable_with_ecriture_all($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_operation t join t_ecriture on ref_operation=t.idt_operation where 1 group by t.idt_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_operation_comptable_with_ecriture_oc($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_operation t join t_ecriture on ref_operation=t.idt_operation where ref_type_operation='OC' group by t.idt_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_compte_detail_new($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_livre_compte t where ref_agence=" . $_SESSION['my_agence']);


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['account_no'] == $choosed) {

            $content = $content . '<option value="' . $result['account_no'] . '" selected>' . $result['account_no'] . " - " . $result['label'] . ' | ' . $result['solde_final'] . ' ' . $result['ref_devise'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['account_no'] . '" >' . $result['account_no'] . " - " . $result['label'] . ' | ' . $result['solde_final'] . ' ' . $result['ref_devise'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_compte_detail($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_live_compte where ref_agence=" . $_SESSION['my_agence']);
    //echo "select * from t_live_compte where ref_agence=".$_SESSION['my_agence'];

    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['account_no'] == $choosed) {

            $content = $content . '<option value="' . $result['account_no'] . '" selected>' . $result['account_no'] . " - " . $result['label'] . ' | ' . $result['solde_final'] . ' ' . $result['ref_devise'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['account_no'] . '" >' . $result['account_no'] . " - " . $result['label'] . ' | ' . $result['solde_final'] . ' ' . $result['ref_devise'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_compte_2($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_livre_compte where ref_agence=" . $_SESSION['my_agence']);


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['account_no'] == $choosed) {

            $content = $content . '<option value="' . $result['account_no'] . '" selected>' . $result['account_no'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['account_no'] . '" >' . $result['account_no'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_operation_comptable_with_ecriture($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_operation t join t_ecriture on ref_operation=t.idt_operation where t.ref_type_operation='OC' group by t.idt_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_operation_comptable_with_ecriture_oe($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_operation t join t_ecriture on ref_operation=t.idt_operation where t.ref_type_operation='OE' group by t.idt_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_operation_comptable_with_ecriture_op($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select t.* from t_operation t join t_ecriture on ref_operation=t.idt_operation where t.ref_type_operation='OP' group by t.idt_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_operation_code($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select label from t_operation");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['label'] == $choosed) {

            $content = $content . '<option value="' . $result['label'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['label'] . '" >' . $result['label'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_source_action($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select distinct source_action from t_grand_journal");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['source_action'] == $choosed) {

            $content = $content . '<option value="' . $result['source_action'] . '" selected>' . $result['source_action'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['source_action'] . '" >' . $result['source_action'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_user_login($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_user order by username asc");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['iduser'] == $choosed) {

            $content = $content . '<option value="' . $result['username'] . '" selected>' . $result['username'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['username'] . '">' . $result['username'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}

function getcombo_description_notification($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select distinct description from t_notification");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['description'] == $choosed) {

            $content = $content . '<option value="' . $result['description'] . '" selected>' . $result['description'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['description'] . '" >' . $result['description'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}
function getcombo_liste_procedure($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select *  from t_procedure");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_procedure'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_procedure'] . '" selected>' . $result['nom_procedure'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_procedure'] . '" >' . $result['nom_procedure'] . '</option>';
        }
    }


    $content = $content;
    return $content;
}


function getcombo_element_restriction_statut($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_statut_dossier where label not in ('" . str_replace(",", "','", $choosed) . "')");


    while ($result = mysqli_fetch_array($sql_query)) {

        $content = $content . '<option value="' . $result['label'] . '">' . $result['label'] . '</option>';
    }


    $content = $content;
    return $content;
}
function getcombo_element_restriction_sms($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "select * from t_statut_dossier where label not in ('" . str_replace(",", "','", $choosed) . "')");


    while ($result = mysqli_fetch_array($sql_query)) {

        $content = $content . '<option value="' . $result['label'] . '">' . $result['label'] . '</option>';
    }


    $content = $content;
    return $content;
}
function getAgence($agence)
{
    include("param.php");
    $sql_query = $bdd->query("select label from t_agence where id_agence=" . $agence);
    $donnee = $sql_query->fetch();
    $data = $donnee['label'];
    return $data;
}


function getCompte($account_no, $agence)
{
    include("param.php");
    $sql_query = $bdd->query("select label from t_livre_compte where account_no='" . $account_no . "'and ref_agence=" . $agence . "");
    $donnee = $sql_query->fetch();
    $data = $donnee['label'];
    return $data;
}

function get_profile($choosed)
{
    include("param.php");
    $content = "";
    $sql_query = $bdd->query("select name,idprofile from t_profile where idprofile<>1  order by name asc");


    while ($result = $sql_query->fetch()) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idprofile'] == $choosed) {

            $content = $content . '<option value="' . $result['idprofile'] . '" selected>' . $result['name'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idprofile'] . '">' . $result['name'] . '</option>';
        }
    }
    $content = $content;
    return $content;
}


function get_operation_customer($choosed)
{

    include("param.php");
    $content = "";
    $sql_query = mysqli_query($bdd_i, "SELECT t.* FROM t_operation t where t.exposed_to_customer = 1");


    while ($result = mysqli_fetch_array($sql_query)) {

        //$content=$content.'<option value="'.$result['content'].'">'.$result['content'].'</option>';
        if ($result['idt_operation'] == $choosed) {

            $content = $content . '<option value="' . $result['idt_operation'] . '" selected>' . $result['label'] . '</option>';
        } else {

            $content = $content . '<option value="' . $result['idt_operation'] . '" >' . $result['label'] . '</option>';
        }
    }
    return $content;






}

