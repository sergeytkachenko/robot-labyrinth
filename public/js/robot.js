var Robot = function (map) {
    var self = this;

    this.map = map;
    this.delay = 20;

    this.absoluteHistory = [];
    this.history = [];

    this.move = function () {
        if(self.map.currentCell[0] == self.map.finishCell[0] && self.map.currentCell[1] == self.map.finishCell[1] ) {
            alert('Finish!');
            setTimeout(location.reload(), 1000);
            return;
        }
        $.ajax({
            url: '/robot/move.json',
            data : {
                map : JSON.stringify(this.map.coordinatesRead),
                absoluteHistory : JSON.stringify(self.absoluteHistory),
                history : JSON.stringify(self.history),
                currentCell : JSON.stringify(this.map.currentCell),
                finishCell : JSON.stringify(this.map.finishCell)
            },
            success: function (data) {
                if(data.success === false) {
                    alert(data.msg);
                    setTimeout(location.reload(), 1000);
                    return;
                }

                var move = data.move;
                self.history = data.history;
                self.absoluteHistory.push(move)

                self.map.setCurrentCell(move);
                self.map.displayCurrent(move);

                setTimeout(function () {self.move()}, self.delay);
            },
            type : 'POST'
        });
    }
}