<!doctype html>
<html lang="en">
<?php
include('./engine.php');
?>

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</head>

<body class="bg-dark" style="font-family:'Courier New', Courier, monospace">
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="p-5 mb-4 text-light rounded-3">
            <div class="container ">
                <h1 class="display-5 fw-bold">RyHme Generator</h1>
                <input class="form-control my-2" id="wbox" onkeyup="inpute()">
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="cm"
                        value="correctmatch"
                        onclick="inpute()" />
                    <label class="form-check-label" for="">1 e 1 eşleşsin</label>
                </div>


                <button class="btn btn-primary btn-lg" type="button" onclick="inpute()">
                    kelimeleri getir
                </button>
                <div>
                    <input type="text" class="form-control my-2" id="fw" >
                </div>
                <div class="text-light p-2" id="output" style='max-height:500px;overflow-y:scroll;position:relative;'>

                </div>
            </div>
        </div>

    </main>
    <footer>
        <div class="text-center text-light">Powered by: ÇÖZELTİ SOFTWARE</div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    
    <script>
         $(document).ready(function() {
            $("#fw").on("keyup", function() {
                console.log('asad')
                var value = $(this).val().toLowerCase();
                $("#popo li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        //document.getElementById("wbox").addEventListener('keyup',inpute())
        function inpute() {
            console.log(document.getElementById('wbox').value)
            $.ajax({
                url: "engine.php", // Veri gönderilecek veya alınacak PHP dosyası
                method: "POST", // GET veya POST yöntemlerinden biri (varsayılan: GET)
                data: {
                    type: "letter",
                    w: document.getElementById('wbox').value,
                    p: document.getElementById('cm').checked
                },
                success: function(response) {
                    // Sunucudan gelen cevap buraya yazdırılır
                    document.getElementById('output').innerHTML = response;
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Hata durumunda çalışacak fonksiyon
                    console.log("Hata oluştu: " + errorThrown);
                }
            });
        }
        
        
    </script>
</body>

</html>