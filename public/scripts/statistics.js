class PDFCreator {
    static createHeaders(keys) {
        const result = [];
        for (let i = 0; i < keys.length; i += 1) {
            result.push({
                id: keys[i],
                name: keys[i],
                prompt: keys[i],
                width: 65,
                align: "center",
                padding: 0
            });
        }
        return result;
    }

    static generateData = function(toModify) {
        for (let i = 0; i < toModify.length; i += 1) {

            toModify[i].place = i.toString();
            for (const key of Object.keys(toModify[i])) {
                toModify[i][key] = toModify[i][key].toString();
            }
        }
        return toModify;
    };
}

class HTMLGenerator{
    static result='';
    static createHead(title)
    {
        this.result = '<head><title>' + title + '</title></head>';
    }

    static createBody(values,headers)
    {
        this.result += '\n<body style="display:flex;justify-content: center">';

        let tableH = '';
        for (let header of headers) {
            tableH += '<td>' + header + '</td>\n';
        }

        this.result += '<table>\n' +
            '<thead><tr>' + tableH +'</tr></thead>\n'+
            '<tbody>';
        for (const row of values) {
            let tempRow = '<tr>';
            for (let key of headers) {
                tempRow += '<td>' + row[key] + '</td>';
            }
            this.result += tempRow;
        }
        this.result += '</tbody>\n</table>\n</body>';
    }
}


const writer = new jsPDF('portrait', 'px','a4');
document.querySelector('#pdf-download').addEventListener('click', async function (event) {
    let request = new XMLHttpRequest();
    request.open('GET', "/getStatistics", true);
    request.responseType = 'json';

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            response = PDFCreator.generateData(response);

            console.log(response);

            let headers = PDFCreator.createHeaders(["place","username", "starsReceived","solved", "successRate"]);

            writer.table(1, 30, response, headers, {autoSize: true});
            writer.save("statistics.pdf");
        }
    }

    request.send();
});

document.querySelector('#html-download').addEventListener('click', async function (event) {
    event.preventDefault();
    let request = new XMLHttpRequest();
    request.open('GET', "/getStatistics", true);
    request.responseType = 'json';

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            response = PDFCreator.generateData(response);

            let toDownload = '<html lang="">';
            HTMLGenerator.createHead('SQL-GAMES Statistics');
            HTMLGenerator.createBody(response,["username", "starsReceived","solved", "successRate"]);
            toDownload += HTMLGenerator.result + '</html>';

            let button = document.createElement('a');
            button.setAttribute('href','data:text/html;charset=utf-8,'+encodeURIComponent(toDownload));
            button.setAttribute('download','statistics.html');

            button.click();
        }
    }

    request.send();
});