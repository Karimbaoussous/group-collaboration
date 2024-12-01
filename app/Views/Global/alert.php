


<? if(isset($redirect)): ?>

    <p>
        <? echo $msg; ?>
    </p>

    <button onclick="window.location = '<? echo base_url($redirect); ?>'">
        ok
    </button>


<? else: ?>

    <script>
        alert('<? echo $msg; ?>')
    </script>

<? endif ?>