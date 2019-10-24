<?php include __DIR__ . "/../includes/module_header.php"; ?>
<div class="m-portlet__body p-1">

    <div class="row">
        <div class="col-sm-6">

            <div id="srcTree" class="tree-demo">
                <ul>
                    <li>
                        Root node 1
                        <ul>
                            <li data-jstree='{ "selected" : true }'>
                                <a href="javascript:;"> Initially selected </a>
                            </li>
                            <li data-jstree='{ "icon" : "fa fa-briefcase m--font-success " }'> custom icon URL</li>
                            <li data-jstree='{ "opened" : true }'>initially open
                                <ul>
                                    <li data-jstree='{ "disabled" : true }'> Disabled Node</li>
                                    <li data-jstree='{ "type" : "file" }'> Another node</li>
                                </ul>
                            </li>
                            <li data-jstree='{ "icon" : "fa fa-warning m--font-danger" }'>
                                Custom icon class (bootstrap)
                            </li>
                        </ul>
                    </li>
                    <li data-jstree='{ "type" : "file" }'>
                        <a href="http://www.keenthemes.com"> Clickanle link node </a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-sm-6">
            <div id="destTree" class="">
                <ul>
                    <li data-jstree='{ "selected" : true }'><a href="javascript:;"> Initially selected </a></li>
                    <li data-jstree='{ "icon" : "fa fa-briefcase m--font-success " }'> custom icon URL</li>
                    <li data-jstree='{ "icon" : "fa fa-warning m--font-danger" }'> Custom icon class (bootstrap)</li>
                    <li data-jstree='{ "type" : "file" }'><a href="http://www.keenthemes.com"> Clickanle link node </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>


<script>


    $(function () {

        $('#srcTree').jstree({
            'core': {
                check_callback: true, "themes": {
                    "responsive": false
                }
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder m--font-brand"
                },
                "file": {
                    "icon": "fa fa-file  m--font-brand"
                }
            },
            "state": {"key": "demo2"},
            "plugins": ["dnd", "contextmenu", "sort"],

        });
        $('#destTree').jstree({
            "types": {
                "default": {
                    "icon": "fa fa-folder m--font-brand"
                },
                "file": {
                    "icon": "fa fa-file  m--font-brand"
                }
            }, 'core': {check_callback: true}, "plugins": ["dnd"],
        });

        srcTree = $('#srcTree').jstree(true);
        destTree = $('#destTree').jstree(true);

        /* for (i = 1; i < 11; i++) {
         srcTree.create_node('#', {id: 'tn' + i, text: 'Node_' + i, data: {id: 'some Data - ' + i}});
         }*/

        $('button').on('click', function () {
            srcNode = srcTree.get_node(srcTree.get_selected());
            destNode = destTree.get_node(destTree.get_selected());
            result = 'SourceNode:<br>id: ' + srcNode.id + '<br>Data: ' + srcNode.data.id + '<br><br>';
            result += 'DestinationNode:<br>id: ' + destNode.id + '<br>Data: ' + (destNode.data || '');
            $('#result').html(result);
        });

        $('#destTree').on('copy_node.jstree', function (e, data) {
            data.instance.set_id(data.node, data.original.id);
            for (var i = 0, j = data.node.children_id; i < j; i++) {
                data.instance.set_id(data.node.children_d[i], data.original.children_d[i]);
            }
        });

    })
</script>