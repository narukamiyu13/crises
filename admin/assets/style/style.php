<?php
/* -------------------------------------
| fichier style.php
| -------------------------
| CONTRIBUTEURS
|   Auteur: Cédrick Collin
|   Modifications: Cédrick Collin
| -------------------------
| DATES
|   Création: 28 avril 2017
|   Dernière Modification: 1 juin 2017
| -------------------------
| DESCRIPTION
|   Les différents styles du panneau d'administration
|------------------------------------- */
session_start();
header("Content-type: text/css; charset: UTF-8"); 
var_dump($_SESSION);
$couleur = $_SESSION['couleur'];
?>


/* ---------- STYLES GÉNÉRAUX ------------- */
h2,h3,p, span{
    font-family:robotoregular;
}

h2{
    font-size:1.6em;
    font-family:robotocondensed;
}

#btDeconnexion{
    position:fixed;
    top:10px;
    right:10px;
    padding:5px;
    border:1px solid <?= $couleur ?>;
    color:<?= $couleur ?>;
    cursor:pointer;
    transition: .2s ease;
}

#btDeconnexion:hover {
    color:white;
    background-color:<?= $couleur ?>;
}


/* ---------- STYLES FORM CONNEXION ------------- */
#index h2, #firstLogin h2{
    margin:15px auto;
}

#index, #firstLogin {
    text-align:center; 
    padding-top:15%;
}

#index input {
    display:block;
    width:300px;
    height:30px;
    margin:10px auto;
    font-family:robotolight;
    font-size:1.1em;
    border:1px solid #A47102;
    padding-left:5px;
    color:#0F0F0F;
}

#index input::-webkit-input-placeholder{
    font-family:robotolight_italic;
}

#index input::-ms-input-placeholder{
    font-family:robotolight_italic;
}

#index input::-moz-placeholder{
    font-family:robotolight_italic;
}

#index input:-moz-placeholder{
    font-family:robotolight_italic;
}

#index input[type='submit'] {
    border:1px solid #A47102;
    width:200px;
    height:60px;
    background-color:transparent;
    color:#A47102;
    transition: background-color .2s ease, color .2s ease;
    cursor:pointer;
}

#index input[type='submit']:hover{
    background-color:#A47012;
    color:#FCFCFC;
}


/* ---------- STYLES FIRST LOGIN ------------- */

#firstLogin h3 {
    margin-top:15px;
    font-size:1.3em;
    font-family:robotocondensed;
}

#firstLogin input {
    display:inline-block;
    width:300px;
    height:30px;
    margin:10px auto;
    font-family:robotolight;
    font-size:1.1em;
    border:1px solid #A47102;
    padding-left:5px;
    color:#0F0F0F;
}

#firstLogin input::-webkit-input-placeholder{
    font-family:robotolight_italic;
}

#firstLogin input::-ms-input-placeholder{
    font-family:robotolight_italic;
}

#firstLogin input::-moz-placeholder{
    font-family:robotolight_italic;
}

#firstLogin input:-moz-placeholder{
    font-family:robotolight_italic;
}

#firstLogin input[type='password']{
    position:relative;
    left:127.5px;
}

#firstLogin input[type='submit'] {
    border:1px solid #A47102;
    width:200px;
    height:60px;
    background-color:transparent;
    color:#A47102;
    transition: background-color .2s ease, color .2s ease;
    cursor:pointer;
}

#firstLogin input[type='submit']:hover{
    background-color:#A47012;
    color:#FCFCFC;
}

#firstLogin input[type='submit'] {
    border:1px solid #A47102;
    width:200px;
    height:60px;
    background-color:transparent;
    color:#A47102;
    transition: background-color .2s ease, color .2s ease;
    cursor:pointer;
}

#firstLogin input[type='submit']:disabled, #firstLogin input[type='submit']:disabled:hover{
    cursor:default;
    background-color:transparent;
    border:1px solid #666;
    color:#666;
}

#firstLogin input + span {
    display:inline-block;
    width:255px;
    position:relative;
    left:127.5px;
    top:0;
}

#firstLogin select {
    height:33px;
    border:1px solid #A47102;
    position:relative;
    bottom:1px;
}

#firstLogin hr {
    border:none;
    margin:15px auto;
}

/* ----------- Styles généraux du dashboard    -----------  */


.previous, .next {
    position:absolute;
    left:25px;
    top:125px;
    font-size:2em;
    color:<?= $couleur?>;
    width:40px;
    height:40px;
    border-radius:50%;
    border:1px solid <?= $couleur?>;
    text-align: center;
    line-height: 33px;
    transition: color .2s ease, background-color .2s ease;
}

.previous:hover, .next:hover {
    color:#FCFCFC;
    background-color:<?= $couleur?>;
}

.previous a {
    color:inherit;
    text-decoration:none;
}

.dashboard {
    text-align:center;
    padding-top:20%;
}

.dashboard h3 {
    font-size:1.5em;
}

.dashboard h2 {
    margin-bottom:50px;
    font-size:1.9em;
}
.dashboard img {
    position:absolute;
    left:0;
    top:0;
}

.dash-button {
    display:inline-block;
    width:200px;
    height:100px;
    border:1px solid <?= $couleur?>;
    padding:10px;
    color:<?= $couleur?>;
    font-family:robotolight;
    font-size:1.2em;
    text-decoration:none;
    vertical-align:middle;
    margin-right:100px;
    margin-bottom:100px;
    color:<?= $couleur?>;
    transition:color .2s ease, background-color .2s ease;
}

.dash-button:hover {
    background-color:<?= $couleur?>;
    color:#FCFCFC;
}

.dash-button a, .dash-button a:visited {
    margin-top:15px;
    display:inline-block;
    width:200px;
    height:100%;
    color:inherit;
    text-decoration:none;
}

.gererAdmins h3, .gererPassword h3, .gererParametres h3, .gererContenu h3, .gererServices h3, .gererTemoignages h3 {
    margin-top:-100px;
}



/* styles gérer admin  */

.gererAdmins form input, .gererAdmins form select {
    width:245px;
    height:50px;
    border:1px solid <?= $couleur?>;
    font-size:1.2em;
    padding-left:5px;
    margin-right:10px;
    margin-bottom:10px;
}

.gererAdmins form input[type='submit']{
    cursor:pointer;
    background-color:transparent;
    color:<?= $couleur?>;
    transition:color .2s ease, background-color .2s ease;
}

.gererAdmins form input[type='submit']:hover{
    background-color:<?= $couleur?>;
    color:#FCFCFC;
}

.collapsable {
    overflow:hidden;
}

.collapsed {
    height: 0;
}


#listeAdmins{
    width:800px;
    margin:0 auto;
    text-align:left;
}

#listeAdmins p{
    min-height:30px;
    padding-top:5px;
    position:relative;
}

#listeAdmins p span:first-of-type, #listeAdmins p span:nth-of-type(2) {
    display:inline-block;
    width:125px;
}

#listeAdmins p span:last-of-type{
    position:absolute;
    right:0;
}

#listeAdmins p:nth-of-type(2n+2){
    background-color:#DDD;
}

#listeAdmins p span:last-of-type a{
    color: <?= $couleur?>;
    display: inline-block;
    background-color:transparent;
    width: 25px;
    height: 25px;
    border: 1px solid <?= $couleur?>;
    text-align: center;
    transition:color .2s ease, background-color .2s ease;
}

#listeAdmins p span:last-of-type a:hover{
    background-color:<?= $couleur?>;
    color:#FCFCFC;
}


#listeAdmins p span:last-of-type a svg{
    width: 20px;
    height: 20px;
    fill: currentColor;
    margin-top: 2.5px;;
}

#modalEdit{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background-color:rgba(0,0,0,0.15);
}

#editModalContent{
    width:600px;
    height:500px;
    padding:30px;
    background-color:white;
    margin:0 auto;
    margin-top:100px;
}

#editModalContent h2 {
    margin-bottom:90px;
}

#editModalContent input, #editModalContent select {
    width:500px;
}

.gererPassword input[type='password'] {
    display:inline-block;
    
    width:245px;
    height:35px;
    border:1px solid <?= $couleur?>;
    padding-left:5px;
}

.gererPassword input[type='submit'] {
    display:block;
    margin:20px auto;
    width:150px;
    height:35px;
    border:1px solid <?= $couleur?>;
    padding-left:5px;
    background-color:transparent;
    color:<?= $couleur?>;
    cursor:pointer;
    transition: .2s color ease, .2s background-color ease;
}

.gererPassword input[type='submit']:hover {
    color:#FCFCFC;
    background-color:<?= $couleur?>;
}

.gererPassword input[type='submit']:disabled,.gererPassword input[type='submit']:disabled:hover {
    cursor:default;
    background-color:transparent;
    border:1px solid #666;
    color:#666;
}

div.input {
    margin:20px auto;
    width:265px;
    position:relative;
}

.inputOk + span {
    position:absolute;
}

.inputOk + span:before{
    content:"\2713";
    color:green;
    position:relative;
    right:20px;
    top:10px;
    font-size:1.2em;
}




/* Styles Gérer Parametres */

.gererParametres h2 {
    margin-bottom:100px;
}

.gererParametres h4{
    font-family:robotobold_condensed;
    font-size:1.2em;
    margin-bottom:15px;
    margin-top:25px;
}

.gererParametres #cotisation input[type='number']{
    margin-bottom:15px;
    width:30px;
    height:20px;
    text-align:right;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
}

.gererParametres #cotisation input[readonly]{
    background-color:#CCC;
    color:#888;
}

.gererParametres .switch + p {
    display:inline-block;
    width: 350px;
    margin-left: 15px;
    vertical-align: baseline;
    margin-bottom: 15px;
}

.gererParametres .switch {
    width:40px;
    height:22px;
    position:relative;
    display:inline-block;
}

.gererParametres .switch input {
    display:none;
}

.slider {
    position:absolute;
    cursor:pointer;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color: #CCC;
    transition: .3s;
}

.gererParametres .slider:before {
    position:absolute;
    content: "";
    height:18px;
    width:18px;
    left:2px;
    bottom:2px;
    background-color:white;
    transition:.4s;
}

.gererParametres .switch input:checked + .slider {
    background-color:<?=$couleur ?>;
}

.gererParametres .switch input:checked + .slider:before {
    transform:translateX(18px);
}

.gererParametres form {
    display:block;
    width:1000px;
    margin:0 auto;
}

.gererParametres div[id^='param-']{
    float:left;
    width:495px;
    text-align:left;
}

.gererParametres div#param-droite .pastille {
    display:inline-block;
    width:150px;
    height:80px;
    margin-right:10px;
    margin-top:20px;
    margin-bottom:50px;
    cursor:pointer;
}

.gererParametres div#param-droite .pastille p {
    position:relative;
    top:-20px;
}

.gererParametres input[type='submit'] {
    width: 250px;
    height: 50px;
    background-color: transparent;
    border: 1px solid <?=$couleur ?>;
    color: <?=$couleur ?>;
    margin-top: -178px;
    margin-bottom: 100px;
    margin-right: -694px;
    cursor:pointer;
    transition: color .2s ease, background-color .2s ease;
}

.gererParametres input[type='submit']:hover {
    color:#FCFCFC;
    background-color:<?=$couleur ?>;
}

.gererParametres #coordonnees p {
    margin-top:15px;
}

.gererParametres #coordonnees input {
    display:inline-block;
    width:90%;
    height:30px;
}

.gererParametres #coordonnees input[name='posteAdmin'] {
    display:inline-block;
    width:10%;
    height:30px;
}

.gererParametres #modalDeleteConfirm {
    position:fixed;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color:rgba(0,0,0,0.2);
    display:none;
}

.gererParametres #modalDeleteConfirm #modaleDeleteContent {
    width:610px;
    height:325px;
    margin:0 auto;
    margin-top:150px;
    background-color:white;
    padding-top:75px;
}

.gererParametres #modalDeleteConfirm #modaleDeleteContent .btConfirm{
    display:inline-block;
    width:100px;
    height: 60px;
    border: 1px solid <?=$couleur ?>;
    color:<?= $couleur ?>;
    line-height:60px;
    margin: 130px 100px 0 100px;
    cursor:pointer;
    transition: .2s ease;
}

.gererParametres #modalDeleteConfirm #modaleDeleteContent .btConfirm:hover{
    transform:scale(1.05);
}

.gererParametres #modalDeleteConfirm #modaleDeleteContent .btConfirm.oui:hover, .gererParametres #modalDeleteConfirm #modaleDeleteContent .btConfirm.non{
    background-color:<?=$couleur ?>;
    color:white;
}

/* STYLES GÉRER CONTENU */

.gererContenu .pageContenu {
    position:fixed;
    top:400px;
    cursor:pointer;
}

.gererContenu .previous.pageContenu {
    left:25px;
}

.gererContenu .next.pageContenu {
    left:25px;
    top:450px;
}

.gererContenu #conteneurBoutons{
    margin-left:250px;
    height:550px;
    width:900px;
    overflow:hidden;
   
}

.gererContenu #conteneurEBoutons{
    width:1000vw;
    transition: margin-left .4s ease;
}

.gererContenu h2 {
    margin-bottom:100px;
}

.gererContenu .dash-button {
    margin-bottom:60px;
}

.gererServices input[type='submit']{
    margin-top:50px;
    margin-right:0;
    width: 250px;
    height: 50px;
    background-color: transparent;
    border: 1px solid <?=$couleur ?>;
    color: <?=$couleur ?>;
    cursor: pointer;
    transition: color .2s ease, background-color .2s ease;
}

.gererServices input[type='submit']:hover {
    color: #FCFCFC;
    background-color: <?=$couleur ?>;
}

.gererServices h3 + h2 {
margin-bottom:20px;
}

.gererTemoignages #left, .gererTemoignages #right{
    width:45%;
    float:left;
    margin-left:15px;
}


.gererTemoignages #left input,.gererTemoignages #left select, .gererTemoignages #left textarea,.gererDocuments input[type='file'] + label  {
    width:98%;
    height:50px;
    border:1px solid <?= $couleur?>;
    font-size:1.2em;
    padding-left:5px;
    margin-right:10px;
    margin-bottom:10px;
}

.gererTemoignages #left textarea {
    height:300px;
    resize: none;
}

.gererTemoignages input[type='submit'], .gererDocuments input[type='file'] + label {
    cursor:pointer;
    background-color:transparent;
    color:<?= $couleur?>;
    transition:color .2s ease, background-color .2s ease;
}

.gererTemoignages form input[type='submit']:hover, .gererDocuments input[type='file'] + label:hover {
    background-color:<?= $couleur?>;
    color:#FCFCFC;
}

#listeTemoignages{
    width:100%;
    margin:0 auto;
    text-align:left;
}

#listeTemoignages p{
    min-height:30px;
    padding-top:5px;
    position:relative;
    
}

#listeTemoignages p span span {
display:inline !important;
position:relative !important;
}



#listeTemoignages p span:first-of-type, #listeTemoignages p span:nth-of-type(2) {
    display:inline-block;
    width:125px;  
} 

#listeTemoignages p span:nth-of-type(2) {
    width:55%;   
}


#listeTemoignages p span:last-of-type{
    position:absolute;
    right:0;
}

#listeTemoignages p:nth-of-type(2n+2){
    background-color:#DDD;
}

#listeTemoignages p span:last-of-type a{
    color: <?= $couleur?>;
    display: inline-block;
    background-color:transparent;
    width: 25px;
    height: 25px;
    border: 1px solid <?= $couleur?>;
    text-align: center;
    transition:color .2s ease, background-color .2s ease;
}

#listeTemoignages p span:last-of-type a:hover{
    background-color:<?= $couleur?>;
    color:#FCFCFC;
}


#listeTemoignages p span:last-of-type a svg{
    width: 20px;
    height: 20px;
    fill: currentColor;
    margin-top: 2.5px;;
}

.gererDocuments input[type='file']{
    width:0.1px;
    height:0.1px;
    opacity:0;
    position:absolute;
    z-index:-1;
}

.gererDocuments input[type='file'] + label {
display:block;
line-height:50px;
font-family:robotoRegular;
}