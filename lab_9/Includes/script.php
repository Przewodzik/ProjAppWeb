<script>
    // Obsługa zdarzeń dla elementów <a> wewnątrz elementu <nav>
    $("nav a").on({
        // Zdarzenie najechania myszką na link
        "mouseover": function() {
            // Animacja zwiększająca rozmiar czcionki do 32px w ciągu 800ms
            $(this).animate({
                fontSize: '32px'
            }, 800);
        },
        // Zdarzenie opuszczenia myszką linku
        "mouseout": function() {
            // Animacja zmniejszająca rozmiar czcionki do 28px w ciągu 800ms
            $(this).animate({
                fontSize: '28px'
            }, 800);
        }
    });
</script>
</body>
</html>
