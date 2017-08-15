angular.module('ConfigController', []).controller('ConfigController', ['$scope', '$location', '$routeParams', 'Config', 'SweetAlert',
    function ($scope, $location, $routeParams, Config, SweetAlert) {
        mxConstants.SHADOWCOLOR = '#C0C0C0';

        Config.get({confId: 1}, function (result) {
            $scope.config = result;
            $scope.main();
        });
        // Program starts here. Creates a sample graph in the
        // DOM node with the specified ID. This function is invoked
        // from the onLoad event handler of the document (see below).
        $scope.main = function () {
            // Checks if browser is supported
            if (!mxClient.isBrowserSupported()) {
                // Displays an error message if the browser is
                // not supported.
                mxUtils.error('Browser is not supported!', 200, false);
            } else {
                // Workaround for Internet Explorer ignoring certain styles
                var container = document.createElement('div');
                container.style.position = 'absolute';
                container.style.overflow = 'hidden';
                container.style.left = '0px';
                container.style.top = '0px';
                container.style.right = '0px';
                container.style.bottom = '0px';

                var outline = document.getElementById('outlineContainer');

                mxEvent.disableContextMenu(container);

                if (mxClient.IS_QUIRKS) {
                    document.body.style.overflow = 'hidden';
                    new mxDivResizer(container);
                    new mxDivResizer(outline);
                }

                // Sets a gradient background
                if (mxClient.IS_GC || mxClient.IS_SF) {
                    container.style.background = '-webkit-gradient(linear, 0% 0%, 0% 100%, from(#FFFFFF), to(#E7E7E7))';
                } else if (mxClient.IS_NS) {
                    container.style.background = '-moz-linear-gradient(top, #FFFFFF, #E7E7E7)';
                } else if (mxClient.IS_IE) {
                    container.style.filter = 'progid:DXImageTransform.Microsoft.Gradient(' +
                        'StartColorStr=\'#FFFFFF\', EndColorStr=\'#E7E7E7\', GradientType=0)';
                }

                outline.appendChild(container);

                // Creates the graph inside the given container
                $scope.graph = new mxGraph(container);
                $scope.editor = new mxEditor();
                $scope.editor.graph = $scope.graph;
                // Enables automatic sizing for vertices after editing and
                // panning by using the left mouse button.
                $scope.graph.setCellsMovable(false);
                $scope.graph.setAutoSizeCells(true);
                $scope.graph.setPanning(true);
                $scope.graph.centerZoom = false;
                $scope.graph.panningHandler.useLeftButtonForPanning = true;

                // Displays a popupmenu when the user clicks
                // on a cell (using the left mouse button) but
                // do not select the cell when the popup menu
                // is displayed
                $scope.graph.panningHandler.popupMenuHandler = false;

                // Creates the outline (navigator, overview) for moving
                // around the graph in the top, right corner of the window.
                var outln = new mxOutline($scope.graph, outline);

                // Disables tooltips on touch devices
                $scope.graph.setTooltips(!mxClient.IS_TOUCH);

                // Set some stylesheet options for the visual appearance of vertices
                var style = $scope.graph.getStylesheet().getDefaultVertexStyle();
                style[mxConstants.STYLE_SHAPE] = 'label';

                style[mxConstants.STYLE_VERTICAL_ALIGN] = mxConstants.ALIGN_MIDDLE;
                style[mxConstants.STYLE_ALIGN] = mxConstants.ALIGN_LEFT;
                style[mxConstants.STYLE_SPACING_LEFT] = 54;

                style[mxConstants.STYLE_GRADIENTCOLOR] = '#7d85df';
                style[mxConstants.STYLE_STROKECOLOR] = '#5d65df';
                style[mxConstants.STYLE_FILLCOLOR] = '#adc5ff';

                style[mxConstants.STYLE_FONTCOLOR] = '#1d258f';
                style[mxConstants.STYLE_FONTFAMILY] = 'Verdana';
                style[mxConstants.STYLE_FONTSIZE] = '12';
                style[mxConstants.STYLE_FONTSTYLE] = '1';

                style[mxConstants.STYLE_SHADOW] = '1';
                style[mxConstants.STYLE_ROUNDED] = '1';
                style[mxConstants.STYLE_GLASS] = '1';

                style[mxConstants.STYLE_IMAGE_WIDTH] = '48';
                style[mxConstants.STYLE_IMAGE_HEIGHT] = '48';
                style[mxConstants.STYLE_SPACING] = 8;

                // Sets the default style for edges
                style = $scope.graph.getStylesheet().getDefaultEdgeStyle();
                style[mxConstants.STYLE_ROUNDED] = true;
                style[mxConstants.STYLE_STROKEWIDTH] = 3;
                style[mxConstants.STYLE_EXIT_X] = 0.5; // center
                style[mxConstants.STYLE_EXIT_Y] = 1.0; // bottom
                style[mxConstants.STYLE_EXIT_PERIMETER] = 0; // disabled
                style[mxConstants.STYLE_ENTRY_X] = 0.5; // center
                style[mxConstants.STYLE_ENTRY_Y] = 0; // top
                style[mxConstants.STYLE_ENTRY_PERIMETER] = 0; // disabled

                // Disable the following for straight lines
                style[mxConstants.STYLE_EDGE] = mxEdgeStyle.TopToBottom;

                // Stops editing on enter or escape keypress
                var keyHandler = new mxKeyHandler($scope.graph);

                // Enables automatic layout on the graph and installs
                // a tree layout for all groups who's children are
                // being changed, added or removed.
                var layout = new mxCompactTreeLayout($scope.graph, false);
                layout.useBoundingBox = false;
                layout.edgeRouting = false;
                layout.levelDistance = 60;
                layout.nodeDistance = 16;
                // Defines a new save action
                $scope.editor.addAction('save', function (editor, cell) {
                    var enc = new mxCodec(mxUtils.createXmlDocument());
                    var node = enc.encode($scope.editor.graph.getModel());
                    var xml = mxUtils.getPrettyXml(node);
                    // Gets the subtree from cell downwards
                    var instructions = [];
                    $scope.graph.traverse($scope.graph.model.cells['treeRoot'], true, function (vertex) {
                        var ins = {
                                id: vertex.id,
                                value: vertex.value,
                                root: vertex.root,
                                type: vertex.type,
                                options: vertex.options ? vertex.options : '',
                                isRoot: false
                            }
                        ;
                        ins.options.instruction_id = ins.id;
                        if (vertex.id == 'treeRoot') {
                            ins.isRoot = 1;
                            ins.type = 'answer';
                            ins.options = '';
                            ins.root = 'cem';
                        }
                        instructions.push(ins);

                        return true;
                    });
                    //to send to multiple receipents we could convert message objects To to an array
                    $scope.configObject = {
                        "instructions": instructions,
                        "xml": xml,
                        "id": $scope.config.id

                    };

                    var config = new Config({
                        config: $scope.configObject
                    });
                    config.$save(function (config) {
                        console.log(config);
                        SweetAlert.swal("Configuration saved successfully", "Configuration saved successfully", "success");

                    }, function (err) {
                        console.log(err);
                        //display errors coming from the api here
                        SweetAlert.swal("Configuration save error", err.data.message, "error");
                        return;

                    });
                });
                var toolbar = document.getElementById('toolbarContainer');
                addToolbarButton($scope.editor, toolbar, 'save', 'Save', 'images/save.gif');
                // Allows the layout to move cells even though cells
                // aren't movable in the graph
                layout.isVertexMovable = function (cell) {
                    return true;
                };

                var layoutMgr = new mxLayoutManager($scope.graph);

                layoutMgr.getLayout = function (cell) {
                    if (cell.getChildCount() > 0) {
                        return layout;
                    }
                };


                // Fix for wrong preferred size
                var oldGetPreferredSizeForCell = $scope.graph.getPreferredSizeForCell;
                $scope.graph.getPreferredSizeForCell = function (cell) {
                    var result = oldGetPreferredSizeForCell.apply(this, arguments);

                    if (result != null) {
                        result.width = Math.max(120, result.width - 40);
                    }

                    return result;
                };

                // Sets the maximum text scale to 1
                $scope.graph.cellRenderer.getTextScale = function (state) {
                    return Math.min(1, state.view.scale);
                };

                // Dynamically adds text to the label as we zoom in
                // (without affecting the preferred size for new cells)
                $scope.graph.cellRenderer.getLabelValue = function (state) {
                    var result = state.cell.value;

                    if (state.view.graph.getModel().isVertex(state.cell)) {
                        if (state.view.scale > 1) {
                            result += '\nDetails 1';
                        }

                        if (state.view.scale > 1.3) {
                            result += '\nDetails 2';
                        }
                    }

                    return result;
                };
                // Shows a "modal" window when double clicking a vertex.
                $scope.graph.dblClick = $scope.handleDblClick;
                // Gets the default parent for inserting new cells. This
                // is normally the first child of the root (ie. layer 0).
                var parent = $scope.graph.getDefaultParent();
                var doc = mxUtils.parseXml($scope.config.xml);
                var codec = new mxCodec(doc);
                console.log($scope.config, doc.documentElement);
                codec.decode(doc.documentElement, $scope.graph.getModel());
                $scope.loadInstructions(); //add overlays for existing instructions

            }
        };
        $scope.handleDblClick = function (evt, cell) {
            if (cell != null && this.isCellEditable(cell)) {

                switch (cell.type) {
                    case 'tts':
                        $scope.play = $scope.graph.model.cells[cell.id];
                        $('#play-modal').modal('show');
                        $('#playprompt').val(cell.options.prompt);
                        angular.element($('#playprompt')).triggerHandler('input');
                        break;
                    case 'spell':
                        $scope.spell = $scope.graph.model.cells[cell.id];
                        $('#spell-modal').modal('show');
                        $('#spellprompt').val(cell.options.code);
                        angular.element($('#spellprompt')).triggerHandler('input');
                        break;
                    case 'dtmf':
                        $scope.dtmf = $scope.graph.model.cells[cell.id];
                        $('#dtmf-modal').modal('show');
                        $('#dtmfprompt').val(cell.options.prompt);
                        angular.element($('#dtmfprompt')).triggerHandler('input');
                        break;
                    case 'dtmfr':
                        $scope.dtmfl = $scope.graph.model.cells[cell.id];
                        $('#dtmfl-modal').modal('show');
                        $('#dtmfprompt').val(cell.options.value);
                        angular.element($('#dtmflvalue')).triggerHandler('input');
                        break;
                    case 'record':
                        $scope.record = $scope.graph.model.cells[cell.id];
                        $('#record-modal').modal('show');
                        $('#recordprompt').val(cell.options.prompt);
                        angular.element($('#recordprompt')).triggerHandler('input');
                        break;
                    case 'endcall':
                        label = 'END CALL';
                        break;
                    default:
                        var label = 'Double click to set TTS';
                }
            }

            // Disables any default behaviour for the double click
            mxEvent.consume(evt);
        };
        $scope.save_dtmf = function () {
            console.log($scope.dtmf);
            $scope.graph.model.cells[$scope.dtmf.id] = $scope.dtmf;
            $scope.graph.cellLabelChanged($scope.graph.model.cells[$scope.dtmf.id], $scope.dtmf.options.prompt, true);
            $('#dtmf-modal').modal('hide');
        };
        $scope.save_dtmfl = function () {
            console.log($scope.dtmfl);
            $scope.graph.model.cells[$scope.dtmfl.id] = $scope.dtmfl;
            $scope.graph.cellLabelChanged($scope.graph.model.cells[$scope.dtmfl.id], $scope.dtmfl.options.value, true);
            $('#dtmfl-modal').modal('hide');
        };
        $scope.save_record = function () {
            console.log($scope.record);
            $scope.graph.model.cells[$scope.record.id] = $scope.record;
            $scope.graph.cellLabelChanged($scope.graph.model.cells[$scope.record.id], $scope.record.options.prompt, true);
            $('#record-modal').modal('hide');
        };
        $scope.save_play = function () {
            console.log($scope.play);
            $scope.graph.model.cells[$scope.play.id] = $scope.play;
            $scope.graph.cellLabelChanged($scope.graph.model.cells[$scope.play.id], $scope.play.options.prompt, true);
            $('#play-modal').modal('hide');
        };
        $scope.save_spell = function () {
            console.log($scope.spell);
            $scope.graph.model.cells[$scope.spell.id] = $scope.spell;
            $scope.graph.cellLabelChanged($scope.graph.model.cells[$scope.spell.id], $scope.spell.options.code, true);
            $('#spell-modal').modal('hide');
        };

        function addToolbarButton(editor, toolbar, action, label, image, isTransparent) {
            var button = document.createElement('button');
            button.style.fontSize = '10';
            if (image != null) {
                var img = document.createElement('img');
                img.setAttribute('src', image);
                img.style.width = '16px';
                img.style.height = '16px';
                img.style.verticalAlign = 'middle';
                img.style.marginRight = '2px';
                button.appendChild(img);
            }
            if (isTransparent) {
                button.style.background = 'transparent';
                button.style.color = '#FFFFFF';
                button.style.border = 'none';
            }
            mxEvent.addListener(button, 'click', function (evt) {
                editor.execute(action);
            });
            mxUtils.write(button, label);
            toolbar.appendChild(button);
        };

        // Function to create the entries in the popupmenu
        function createPopupMenu(graph, menu, cell, evt) {
            var model = graph.getModel();

            if (cell != null) {
                if (model.isVertex(cell)) {
                    menu.addItem('Add child', 'images/overlays/check.png', function () {
                        addChild(graph, cell);
                    });
                }

                menu.addItem('Edit label', 'images/text.gif', function () {
                    graph.startEditingAtCell(cell);
                });

                if (cell.id != 'treeRoot' &&
                    model.isVertex(cell)) {
                    menu.addItem('Delete', 'images/delete.gif', function () {
                        deleteSubtree(graph, cell);
                    });
                }

                menu.addSeparator();
            }

            menu.addItem('Fit', 'images/zoom.gif', function () {
                graph.fit();
            });

            menu.addItem('Actual', 'images/zoomactual.gif', function () {
                graph.zoomActual();
            });

            menu.addSeparator();

            menu.addItem('Print', 'images/print.gif', function () {
                var preview = new mxPrintPreview(graph, 1);
                preview.open();
            });

            menu.addItem('Poster Print', 'images/print.gif', function () {
                var pageCount = mxUtils.prompt('Enter maximum page count', '1');

                if (pageCount != null) {
                    var scale = mxUtils.getScaleForPageCount(pageCount, graph);
                    var preview = new mxPrintPreview(graph, scale);
                    preview.open();
                }
            });
        };

        function addOverlays(graph, cell, addDeleteIcon, type) {
            if (type != 'endcall') {
                var overlay = new mxCellOverlay(new mxImage('images/add.png', 24, 24), 'Add action');
                overlay.cursor = 'hand';
                overlay.align = mxConstants.ALIGN_CENTER;
                overlay.addListener(mxEvent.CLICK, mxUtils.bind(this, function (sender, evt) {
                    askChildType(graph, cell);
                }));


                graph.addCellOverlay(cell, overlay);
            }

            if (addDeleteIcon && cell.id != "treeRoot") {
                overlay = new mxCellOverlay(new mxImage('images/close.png', 30, 30), 'Delete');
                overlay.cursor = 'hand';
                overlay.offset = new mxPoint(-4, 8);
                overlay.align = mxConstants.ALIGN_RIGHT;
                overlay.verticalAlign = mxConstants.ALIGN_TOP;
                overlay.addListener(mxEvent.CLICK, mxUtils.bind(this, function (sender, evt) {
                    deleteSubtree(graph, cell);
                }));

                graph.addCellOverlay(cell, overlay);
            }
        };

        function askChildType(graph, cell) {
            var content = document.createElement('div');
            content.style.padding = '4px';
            console.log('asking');
            var tb = new mxToolbar(content);

            tb.addItem('Text To Speech', 'images/tts.png', function (evt) {
                addChild(graph, cell, 'tts');
                $scope.wnd.destroy();
            });

            tb.addItem('Spell Code', 'images/spell.png', function (evt) {
                addChild(graph, cell, 'spell');
                $scope.wnd.destroy();
            });

            tb.addItem('Get DTMF Input', 'images/dtmf.png', function (evt) {
                addChild(graph, cell, 'dtmf');
                $scope.wnd.destroy();
            });
            if (cell.type == 'dtmf') {
                tb.addItem('Add DTMF Logic', 'images/dtmfr.png', function (evt) {
                    addChild(graph, cell, 'dtmfr');
                    $scope.wnd.destroy();
                });
            }
            tb.addItem('Record Voice', 'images/record.png', function (evt) {
                addChild(graph, cell, 'record');
                $scope.wnd.destroy();
            });

            tb.addItem('End Call', 'images/endcall.png', function (evt) {
                addChild(graph, cell, 'endcall');
                $scope.wnd.destroy();
            });
            showModalWindow(graph, 'Choose What to Add Next', content, 390, 90);
        }

        function addChild(graph, cell, type) {
            console.log(cell.getEdgeCount());
            if ((cell.getEdgeCount() - 1 == 0 && cell.id != 'treeRoot') || (cell.id == 'treeRoot' && cell.getEdgeCount() == 0) || (type == 'dtmfr' && cell.id != 'treeRoot')) {

                var model = graph.getModel();
                var parent = graph.getDefaultParent();
                var vertex;
                // var style = graph.getStylesheet().getDefaultVertexStyle();
                // style[mxConstants.STYLE_IMAGE] = 'images/' + type + '.png';
                model.beginUpdate();
                console.log(cell);
                //set up initial label value
                var label = 'Double click to set TTS';
                switch (type) {
                    case 'tts':
                        label = 'Double click to set TTS message';
                        break;
                    case 'spell':
                        label = 'Spell A Code';
                        break;
                    case 'dtmf':
                        label = 'Double click to set DTMF options';
                        break;
                    case 'dtmfr':
                        label = 'Double click to set DTMF logic';
                        break;
                    case 'record':
                        label = 'Double click to set recording options';
                        break;
                    case 'endcall':
                        label = 'End Call';
                        break;
                    default:
                        var label = 'Double click to set TTS';
                }
                try {
                    // $scope.graph.insertVertex(parent, 'treeRoot',
                    //         'Incoming Call', w / 2 - 30, 20, 140, 60, 'image=images/incoming.png;editable=0');
                    vertex = graph.insertVertex(parent, null, label, 10, 20, 140, 60, 'image=images/' + type + '.png;editable=1');
                    var geometry = model.getGeometry(vertex);
                    vertex.type = type;
                    vertex.root = cell.id;
                    vertex.options = {};
                    vertex.options.type = type;
                    //set favourite accent as default :P
                    var voice = {
                        language: "en-GB",
                        gender: "Female",
                        number: 2
                    };
                    //set defaults for instructions
                    switch (type) {
                        case 'tts':
                            vertex.options.type = 'play';
                            vertex.options.prompt = 'prompt#' + vertex.id;
                            vertex.options.prompt_type = 'TTS';
                            vertex.options.terminators = '*';
                            vertex.options.voice = voice;
                            break;
                        case 'spell':
                            vertex.options.code = 'Abra cadabra!#' + vertex.id;
                            vertex.options.code_type = 'TTS';
                            vertex.options.voice = voice;
                            break;
                        case 'dtmf':
                            vertex.options.type = 'get-dtmf';
                            vertex.options.prompt = 'prompt#' + vertex.id;
                            vertex.options.invalid_prompt = 'invalid-prompt#' + vertex.id;
                            vertex.options.prompt_type = 'TTS';
                            vertex.options.invalid_prompt_type = 'TTS';
                            vertex.options.min_digits = 1;
                            vertex.options.max_digits = 1;
                            vertex.options.max_attempts = 4;
                            vertex.options.regex = '[1-9]\\d*';
                            vertex.options.terminators = '#';
                            vertex.options.call_back_url = 'http://cm.cemturk.net/api/cm/callback';
                            vertex.options.voice = voice;
                            break;
                        case 'dtmfr':
                            vertex.options.value = 'set the value to match';
                            break;
                        case 'record':
                            vertex.options.prompt = 'prompt#' + vertex.id;
                            vertex.options.prompt_type = 'TTS';
                            vertex.options.max_recording_time = 30;
                            vertex.options.silence_time = 3;
                            vertex.options.terminators = '*';
                            vertex.options.voice = voice;
                            break;
                        case 'endcall':
                            vertex.options.type = 'disconnect';
                            break;
                    }
                    console.log(vertex);
                    // Updates the geometry of the vertex with the
                    // preferred size computed in the graph
                    var size = graph.getPreferredSizeForCell(vertex);
                    geometry.width = size.width;
                    geometry.height = size.height;

                    // Adds the edge between the existing cell
                    // and the new vertex and executes the
                    // automatic layout on the parent
                    var edge = graph.insertEdge(parent, null, '', cell, vertex);

                    // Configures the edge label "in-place" to reside
                    // at the end of the edge (x = 1) and with an offset
                    // of 20 pixels in negative, vertical direction.
                    edge.geometry.x = 1;
                    edge.geometry.y = 0;
                    edge.geometry.offset = new mxPoint(0, -20);

                    addOverlays(graph, vertex, true, type);

                } finally {
                    model.endUpdate();
                }

                return vertex;

            }
        };


        function showModalWindow(graph, title, content, width, height) {
            var background = document.createElement('div');
            background.style.position = 'absolute';
            background.style.left = '0px';
            background.style.top = '0px';
            background.style.right = '0px';
            background.style.bottom = '0px';
            background.style.background = 'black';
            mxUtils.setOpacity(background, 50);
            document.body.appendChild(background);

            if (mxClient.IS_IE) {
                new mxDivResizer(background);
            }

            var x = Math.max(0, document.body.scrollWidth / 2 - width / 2);
            var y = Math.max(10, (document.body.scrollHeight ||
                document.documentElement.scrollHeight) / 2 - height * 2 / 3);
            $scope.wnd = new mxWindow(title, content, x, y, width, height, false, true);
            $scope.wnd.setClosable(true);

            // Fades the background out after after the window has been closed
            $scope.wnd.addListener(mxEvent.DESTROY, function (evt) {
                graph.setEnabled(true);
                mxEffects.fadeOut(background, 50, true,
                    10, 30, true);
            });

            graph.setEnabled(false);
            graph.tooltipHandler.hide();
            $scope.wnd.setVisible(true);
        };

        $scope.loadInstructions = function () {
            console.log($scope.graph.model.cells);
            // Gets the subtree from cell downwards
            var cells = [];
            $scope.graph.traverse($scope.graph.model.cells['treeRoot'], true, function (vertex) {
                cells.push(vertex);

                return true;
            });
            for (var i = 0; i < cells.length; i++) {
                addOverlays($scope.graph, cells[i], true, cells[i].type);
            }
        };

        function deleteSubtree(graph, cell) {
            // Gets the subtree from cell downwards
            var cells = [];
            $scope.graph.traverse(cell, true, function (vertex) {
                cells.push(vertex);

                return true;
            });

            $scope.graph.removeCells(cells);
        };

    }
]);
