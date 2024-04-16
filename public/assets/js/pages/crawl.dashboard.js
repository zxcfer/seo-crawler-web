crawl_id = (typeof crawl_id === 'undefined') ? null : crawl_id;
cmp_crawl_id = (typeof cmp_crawl_id === 'undefined') ? null : cmp_crawl_id;
oTable = (typeof oTable === 'undefined') ? null : oTable;
home_url = (typeof home_url === 'undefined') ? null : home_url;

getCompareTree = function() {
    var url = home_url + laroute.route('stats-diff', {
        crawl: crawl_id,
        cmpCrawl: $(this).val(),
        typ: 'all'
    });
    console.log(url);
    Ajax.get(url, function(data, status) {
        console.log(data.stats);
        var tree = getTree(data.stats);
	$('#tree').treeview({data: tree});
    });
};

// 'crawl/{crawl}/on-site-urls/{subtyp}/{description}'
getUrl = function (typ, subtyp, desc) {
    var url = null;
    if (typ === 'indexation') {
        url = laroute.route(typ+'-urls', {crawl: crawl_id, description: desc});
    } else if (typ === 'on-site') {
        url = laroute.route(typ+'-urls', {crawl: crawl_id, subtyp: subtyp, description: desc});
    } else if (typ === 'response-codes') {
        url = laroute.route(typ+'-urls', {crawl: crawl_id, code: desc.split(' ')[0]});
    } else if (typ === 'robots') {
        url = laroute.route('non-zero-urls', {crawl: crawl_id, field: typ+'-'+desc});
    } else {
        url = laroute.route('non-zero-urls', {crawl: crawl_id, field: desc});
    }

    console.log(url);
    return url;
};

setTitle = function (id, subtyp, desc) {
    var title = desc.titlerize();
    if (subtyp !== 'null')
        title = subtyp.titlerize()+' - '+title;

    $(id).text(title);
};

reloadDataTable = function() {
    $("#detail-datatable").removeClass('hidden');
    $(".panel-chart").addClass('hidden');

    var typSubtypDesc = $(this).attr('id').split('_');
    var typ = typSubtypDesc[0];
    var subtyp = typSubtypDesc[1];
    var desc = typSubtypDesc[2];

    var url = home_url + getUrl(typ, subtyp, desc);
    oTable.fnReloadAjax(url);
    setTitle('#detail-title', subtyp, desc);

    $('#csv-button').attr('href', url+'?format=csv');
    setTimeout(function() { $('.tree-stat').on("click", reloadDataTable); }, 1200);
};
