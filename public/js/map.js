var Map = function ($table, coordinates) {

    this.maxRow = 0;
    this.maxColumn = 0;

    this.currentCell = [];
    this.startCell = [];
    this.finishCell = [];

    this.coordinatesRead = coordinates;
    this.coordinates = [];

    for(var i in coordinates) {
        var coordinate = coordinates[i];
        this.maxRow = coordinate[0] > this.maxRow? coordinate[0] : this.maxRow;
        this.maxColumn = coordinate[1] > this.maxColumn? coordinate[1] : this.maxColumn;

        this.coordinates[coordinate[0] + '-' + coordinate[1]] = coordinate;
    }

    this.issetCoordinate = function (c) {
        return (typeof this.coordinates[c[0] + '-' + c[1]]) === 'object';
    }

    this.printBoard = function () {
        var html = '';
        for(var i = 1; i < this.maxRow; i++) {
            html += '<tr>';
            for(var k = 1; k < this.maxColumn; k++) {
                html += '<td data-row="'+ i +'" data-column="'+ k +'">';
                var coordinate = [i, k];
                if(this.issetCoordinate(coordinate)) {
                    html += '<i></i>';
                } else {
                    html += ' ';
                }
                html += '</td>';
            }
            html += '</tr>';
        }
        $table.html(html);
    }

    this.setCurrentCell = function (cell) {
        this.currentCell = cell;
    }

    this.displayCurrent = function (cell) {
        $('table#map td:has(i)').removeClass('current');
        var $td = $('td[data-row='+cell[0]+'][data-column='+cell[1]+']');
        $td.addClass('current');
    }

    this.setStartCell = function (cell) {
        this.startCell = cell;
    }

    this.setFinishCell = function (cell) {
        this.finishCell = cell;
    }
}
