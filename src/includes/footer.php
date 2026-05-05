</main>
</div>

<footer>
    <div class="container-38n wrapper-gq5">
        <div class="block-z3r">
            <h3><?php echo getCyrillicAlphabet('Informations'); ?></h3>
            <ul>
                <li><a href="/tai/aide"><?php echo getCyrillicAlphabet('Aide sur le site'); ?></a></li>
                <li><a href="/tai/confidentialite"> <?php echo getCyrillicAlphabet('Confidentialité / Informations personnelles / Cookies et autres traceurs'); ?></a></li>
                <li><a href="/tai/securite"><?php echo getCyrillicAlphabet('Sécurité informatique'); ?></a></li>
                <li><a href="/tai/glossaire"><?php echo getCyrillicAlphabet('Glossaire'); ?></a></li>
                <li><a href="/tai/faq"><?php echo getCyrillicAlphabet('Foire aux questions'); ?></a></li>
            </ul>
        </div>
        <div class="block-z3r">
            <h3><?php echo getCyrillicAlphabet('Qualité de service'); ?></h3>
            <ul>
                <li><a href="/tai/accessibilite"><?php echo getCyrillicAlphabet('Accessibilité : Conformité partielle'); ?></a></li>
                <li><a href="/tai/engagement"><?php echo getCyrillicAlphabet('Les engagements de la DGFiP'); ?></a></li>
            </ul>
        </div>
        <div class="block-z3r">
            <h3><?php echo getCyrillicAlphabet('Autres sites'); ?></h3>
            <ul>
                <li><a class="link-k2c" href="https://www.antai.gouv.fr/"><?php echo getCyrillicAlphabet('ANTAI : Agence nationale de traitement automatisé des infractions'); ?></a></li>
                <li><a href="https://stationnement.gouv.fr/" class="link-k2c"><?php echo getCyrillicAlphabet('Forfait post-stationnement'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-f78">
        <ul>
            <li><a href="https://www.service-public.fr/" class="link-k2c"><?php echo getCyrillicAlphabet('Service-public.fr'); ?></a></li>
            <li><a href="https://www.legifrance.gouv.fr/" class="link-k2c"><?php echo getCyrillicAlphabet('Legifrance.gouv.fr'); ?></a></li>
        </ul>
    </div>
    <div class="footer-pow">
        <p> © <?php echo getCyrillicAlphabet('Direction générale des Finances publiques'); ?> - <a href="/tai/mention-legales"><?php echo getCyrillicAlphabet('Mentions légales'); ?></a></p>
    </div>
</footer>

<div class="wrapper-6za">
    <div class="opaque-ovq style-BD2tV" id="style-BD2tV"></div>
    <div class="pop-9ob"><img src="./../src/images/spinner.9589ae1c.gif">
        <p class="fs-ocq"> <?php echo getCyrillicAlphabet('Chargement en cours. Merci de patienter.'); ?> </p>
    </div>
</div>

<script>
    window.addEventListener('message', function(e) {
        var iframe = document.getElementsByTagName('iframe')[0];
        if (e.data.frameHeight) {
            iframe.style.height = e.data.frameHeight + 'px';
        }

        var wrapper = document.querySelector('.wrapper-6za');
        if (e.data.showWrapper) {
            wrapper.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else if (e.data.hideWrapper) {
            wrapper.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }, false);
</script>
</body>

</html>