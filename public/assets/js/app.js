/* global c3 */
/* global bootbox */

String.prototype.titlerize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

String.prototype.format = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{'+i+'\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i]);
    }
    return formatted;
};

String.prototype.urlize = function() {
    return this.toLowerCase().replace(/\s/g, '-');
};

function App(columnName) {
    "use strict";
    this.columnName = columnName;
    this.columns = [];
}

App.prototype = {
    columnFormatC3: function (historic_items) {
        columns = [[this.columnName]];
	x_text = [['x']];
	for (var i in historic_items) {
            x_text[0].push(historic_items[i].worked_on);
            columns[0].push(historic_items[i].amount);
	}
        this.columns =  x_text.concat(columns);
    },
    columnFormatErrorCount: function (errorCounts) {
        columns = [['Error Count']];
	x_text = [['x']];
	for (var i in errorCounts) {
            x_text[0].push(errorCounts[i].gwt_dump_id);
            columns[0].push(errorCounts[i].total);
	}
        this.columns =  x_text.concat(columns);
    },
    drawLineChart: function (id) {
        types = [];
        types[this.columnName] = 'area-spline';
        chart = c3.generate({
            bindto: id,
            data: { x: 'x', columns: this.columns, types: types},
            axis: { x: { type: 'category' }},
            size: { height: 260 }
        });
    }
};

/**
 * columnsList = [ [['column1', 1, 2, 4]],
 *		   [['column2', 1, 3, 4]],
 *		   [['column2', 1, 3, 4]] ]
 * @param subtyp
 */
function SmallChart(subtyp) {
    "use strict";
    this.columnsList = [];
}

SmallChart.prototype = {
    inList : function(columnsList, name) {
        for (var i in columnsList)
            if (columnsList[i][0][0] === name)
                return i;
        return -1;
    },
    getColumnName : function(stat) {
        var columnName = stat.description.urlize();
        if (stat.subtyp !== null)
            columnName = stat.subtyp.urlize()+'_'+columnName;
        return columnName;
    },
    parseHistoricData: function (historicStats) {
	historicStats.forEach(function (stat, index, array) {
            var columnName = this.getColumnName(stat);
            var columnsIndex = this.inList(this.columnsList, columnName);
            if (columnsIndex < 0) {
                var columns = [[columnName]];
                var len = this.columnsList.push(columns);
                columnsIndex = len-1;
            }
            this.columnsList[columnsIndex][0].push(stat.amount);
	}, this);
    },
    drawColumnsList: function (historicStats) {
        this.parseHistoricData(historicStats);
        this.columnsList.forEach(function (columns, i, array) {
            this.draw(columns);
	}, this);
    },
    draw: function (columns) {
        var types = [];
        types[columns[0][0]] = 'area-spline';
        var bind_to_id = '#chart-'+columns[0][0];
        console.log(bind_to_id);

        chart = c3.generate({
            bindto: bind_to_id,
            data: { columns: columns, types: types },
            size: { height: 50, width: 150 },
            legend: { show: false },
            axis: { x: { show: false }, y: { show: false } }
        });
    }
};

Ajax = {
    get: function (url, success) {
        console.log(url);
        $.ajax({
            dataType: "json",
	    type:     "GET",
	    url:      url,
	    success:  success,
	    error:    this.error_fn
        });
    },
    post: function (url, data, success) {
        console.log(url);
        $.ajax({
            dataType: "json",
	    type:     "POST",
	    data:     data,
	    url:      url,
	    success:  success,
	    error:    this.error_fn
        });
    },
    postForm: function(form_id, success) {
        $form = $(form_id);
        url = $form.attr('action');
        $.ajax({
            dataType: "json",
	    type:     "POST",
	    data:     $form.serialize(),
	    url:      $form.attr('action'),
	    success:  success,
	    error:    this.error_fn
        });
    },
    error_fn: function (xhr, ajaxOptions, thrownError) {
        console.log("Error postJSON '{0}':'{1}'".format(xhr.status));
        console.log(thrownError);
    },
    dataTable: function (url) {
	oTable = $('#detail').dataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": this.text,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "fnDrawCallback": this.reDrawDataTable
	});
    },
    detailDataTable: function (url) {
        var header = "<'row datatable-header'<'col-md-4'l><'col-md-4'r><'col-md-4'f>>";
        var footer = "<'row datatable-footer'<'col-md-6'i><'col-md-6'p>>";
        var records = {"sLengthMenu": "_MENU_ records per page" };

        return $('#detail').dataTable({
            "sDom": header+"t"+footer,
            "sPaginationType": "bootstrap",
            "oLanguage": records,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "iDisplayLength": 25,
            "fnDrawCallback": this.reDrawDataTable
        });
    },
    reDrawDataTable: function() {
        $('.dataTables_filter input').addClass('form-control btn-sm');
        $('.dataTables_length select').addClass('form-control btn-sm');
        $(".delete").on("click", Ajax.on_delete);
    },
    on_delete: function() {
        
        var full_id = $(this).attr('id').split('__');
        var crawl_id = full_id[1];
        var worked_on = "<strong>"+full_id[2]+"</strong>";
        console.log(full_id);
        console.log(crawl_id);
        
        bootbox.confirm('Do you want to delete '+worked_on+' crawl?', function(result) {
            if (result) {
                var url = home_url + laroute.route('crawl_delete', {crawl: crawl_id});
                var data = {_token: crsf_token};
                Ajax.post(url, data, function () {
                    oTable.fnReloadAjax();
                    Ajax.notify('success', "Crawl has been deleted");
                });
            } else {
                Ajax.notify('danger', "Website has not been deleted");
            }
	});
    },
    notify: function (type, message) {
        $.notify(
            {title: message, message: ""},
            {type: type, placement: {from: "top",align: "center"}}
        );
    },
    text: { "sLengthMenu": "_MENU_ websites per page" }
};

crawl_id = (typeof crawl_id === 'undefined') ? null : crawl_id;
cmp_crawl_id = (typeof cmp_crawl_id === 'undefined') ? null : cmp_crawl_id;

getAddedDetailUrl = function (typ, subtyp, desc, incdec) {
    params = {};
    if (incdec === 'increase') {
        params = {crawlId: crawl_id, cmpCrawlId: cmp_crawl_id};
    } else { // decrease
        params = {crawlId: cmp_crawl_id, cmpCrawlId: crawl_id};
    }

    var alias = typ+'-added-urls';
    if (typ === 'indexation') {
        params.description = desc;
    } else if (typ === 'on-site') {
        params.description = desc.urlize();
        params.subtyp = subtyp;
    } else if (typ === 'response-codes') {
        params.code = desc.split(' ')[0];
    } else if (typ === 'robots') {
        params.field =  typ+'-'+desc;
        alias = 'non-zero-added-urls';
    } else {
        params.field =  desc;
        alias = 'non-zero-added-urls';
    }

    var url = laroute.route(alias, params);
    console.log(url);
    return url;
};
