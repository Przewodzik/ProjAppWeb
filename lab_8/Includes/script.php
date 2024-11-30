<script>
    $("nav a").on({
        "mouseover": function() {
            $(this).animate({
                fontSize: '32px'
            }, 800);
        },
        "mouseout": function() {
            $(this).animate({
                fontSize: '28px'
            }, 800);
        }
    });
</script>
</body>
</html>