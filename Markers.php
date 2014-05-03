<?php header('Content-type: image/svg+xml'); ?>
<?xml version="1.0"?>
<svg width="22" height="50" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
    <g>
        <title>Marker</title>
        <path fill="#<?php echo $_GET['ColorAC']; ?>" stroke-miterlimit="10" stroke="black"
              d="m10.99797,40.59101c-2,-20 -10,-22 -10,-30.00002a10,10 0 1 1 19.99999,0c0,8.00002 -7.99999,10.00002 -9.99999,30.00002z"/>
        <text font-weight="bold" xml:space="preserve" text-anchor="middle" font-family="Sans-serif" font-size="8"
              y="14.11321" x="10.98711" fill="#<?php echo $_GET['ColorPS']; ?>"><?php echo intval($_GET['PSNo']); ?></text>
    </g>
</svg>