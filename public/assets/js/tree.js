function contains(array, item) {
    for (var i in array) {
        if (array[i].text.toUpperCase() === item.toUpperCase())
            return i;
    }
    return -1;
}

function insertStat(tree, stat, typ_index, subtyp_index) {
    var subtyp_name = 'null';
    if (typeof stat.subtyp !== 'undefined' && stat.subtyp !== null) // TODO
        subtyp_name = stat.subtyp.urlize();

    var typ_name = 'null';// TODO
    if (typeof stat.typ !== 'undefined' && stat.typ !== null) // TODO
        typ_name = stat.typ.urlize();// TODO
    
    _desc = '<a href="#detail-title" id="{0}_{1}_{2}" class="tree-stat">{3}</a>'.format(
            typ_name,
            subtyp_name,
            stat.description.urlize(),
            stat.description.titlerize());
    _amount = ' (<strong>'+stat.amount+'</strong>)';
    var text = {text: _desc + _amount, selectable: false};
    
    if (stat.subtyp === null) {
        tree[typ_index].nodes.push(text);
    } else {
        tree[typ_index].nodes[subtyp_index].nodes.push(text);
    }
}

function getNodeNumber(tree, typ) {
    for (var i in tree) {
        if (tree[i].text === typ)
            return i;
        else 
            return false;
    }
}

function getTypIndexAndInsert(tree, stat) {
    var typIndex = contains(tree, stat.typ);
    if (typIndex === -1) {
        var length = tree.push({text: stat.typ.titlerize(), selectable: false, nodes: []});
        typIndex = length - 1;
    }
    
    return typIndex;
}

function getSubtypIndexAndInsert(tree, stat, typIndex) {
    if (stat.subtyp !== null && typeof tree[typIndex] !== 'undefined') {
        var subtypIndex = contains(tree[typIndex].nodes, stat.subtyp);
        if (subtypIndex === -1) {
            var length = tree[typIndex].nodes.push({
                text: stat.subtyp.titlerize(), 
                selectable: false,
                nodes: []
            });
            subtypIndex = length - 1;
        }
    } else {
        subtypIndex =  null; // subtyp not defined
    }
    return subtypIndex;
}

function getTree(stats) {
    tree = [];
    for (var i in stats) {
        var stat = stats[i];
        var typIndex = getTypIndexAndInsert(tree, stat);
        var subtypIndex = getSubtypIndexAndInsert(tree, stat, typIndex) ;
        insertStat(tree, stat, typIndex, subtypIndex);
    }
    return tree;
}
