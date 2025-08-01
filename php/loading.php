<!-- REQUIRED JS SCRIPTS -->
<script type="text/javascript">
    function ShowLoading(e) {
        var div = document.createElement('div');
        var img = document.createElement('img');
      //  div.innerHTML = "Veuillez patienter. Ceci peut prendre plusieurs secondes... Svp, ne cliquez sur aucun bouton pendant cette attente !<br /><br /><br />";
        div.id = "pop"
       /* div.style.cssText = 'background-image:url(images/spinner.gif); background-size : auto;  display: block; position: absolute; top: 40%; left: 40%; width: 25%; height: 30%;  padding: 16px; border-radius: 5px 5px 5px 5px;   background-color: white; z-index:1002; overflow: auto; transform-style : preserve-3d;';
        div.appendChild(img);*/

        img.src = 'images/spinner.gif';
        div.innerHTML = "Veuillez patienter. <br />Ceci peut prendre plusieurs secondes... Svp,<br /> ne cliquez sur aucun bouton pendant cette attente !<br /><br /><br />";

        div.style.cssText = 'position: fixed; top: 5%; left: 40%; z-index: 5000; width: 422px; text-align: center; background: white;';

        div.appendChild(img);
        document.body.appendChild(div);
      
       return true;
     
    }

   // ShowLoading();
</script>