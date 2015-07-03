$.ajax({
    url: '/index/map.json?fileMapPath=public/map1.txt',
    success: function (data) {
        window.map = new Map ($('table#map'), data.coordinates);
        window.map.printBoard();

        window.robot = new Robot(window.map);
    }
});

function selectStart () {
    $('table#map td:has(i)').off('click').on('click', function () {
        $('table#map td:has(i)').removeClass('start').off('click');
        $(this).addClass('start');
    });
    //alert('кликните на клеточку');
}

function selectFinish () {
    $('table#map td:has(i)').off('click').on('click', function () {
        $('table#map td:has(i)').removeClass('finish').off('click');
        $(this).addClass('finish');
    });
    //alert('кликните на клеточку');
}

function start () {
    if(!$('table#map td.start').length || !$('table#map td.finish').length) {
        alert('Пожалуйста, выберите старт и финишь для робота, перед началом программы.');
        return;
    }
    var $tdStart = $('table#map td.start'),
        $tdFinish = $('table#map td.finish'),
        cellStart = [$tdStart.attr('data-row'), $tdStart.attr('data-column')],
        cellFinish = [$tdFinish.attr('data-row'), $tdFinish.attr('data-column')];
    map.setStartCell(cellStart);
    map.setCurrentCell(cellStart);
    map.setFinishCell(cellFinish);

    robot.move();
}
