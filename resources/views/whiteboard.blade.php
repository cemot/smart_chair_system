
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Whiteboard</title>

    <!--- JS References -!-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.dev.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="./js/require.js"></script>

    <script type="text/javascript" src="./js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./js/fontawseome5.8.1.min.js"></script>
    <!--- for dragabbles -!-->
    <script type="text/javascript" src="./js/socketio2.0.4.min.js"></script>
    <script type="text/javascript" src="./js/jqColorPicker.min.js"></script>

    <script type="text/javascript" src="./js/whiteboard.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>

    <script type="text/javascript" src=" /./server.js"></script>

    <!--- CSS References -!-->
    <link rel="stylesheet" href="./css/jquery-ui.min.css">
    <link href="./css/main.css" rel="stylesheet">


</head>


<body style="position: relative; margin: 0px; height: 100vh; width: 100%; overflow: hidden;">

<div style="display: block">
    Name:
    <br>
    Title:
    <br>
    Whiteboard IDddddd:

    Token = {{csrf_token()}}

</div>
<div>
<!---Whiteboard container -!-->

    <div style="height: 100vh; width: 100%;" id="whiteboardContainer"></div>

<!---Toolbar -!-->
<div id="toolbar" style="position: absolute; top: 10px; left: 10px;">
    <div class="btn-group">
        <button id="putraFutureClassroom" title="Go to Main Menu" type="button" class="whiteboardBtn">
            <a style="text-decoration:none" href="{{ url('/home')}} ">Main Menu</a>
        </button>



        <button id="whiteboardlist" title="Go to whiteboard list" type="button" class="whiteboardBtn">
            <a style="text-decoration:none" href="{{ url('/whiteboard')}} ">Whiteboards</a>
        </button>


    </div>

    <div class="btn-group">
        <button tool="mouse" title="Take the mouse" type="button" class="whiteboardTool">
            <i class="fa fa-mouse-pointer"></i>
        </button>
        <button style="padding-bottom: 11px;" tool="recSelect" title="Select an area" type="button"
                class="whiteboardTool">
            <img src="./images/dottedRec.png">
        </button>
        <button tool="pen" title="Take the pen" type="button" class="whiteboardTool active">
            <i class="fa fa-pencil-alt"></i>
        </button>
        <button style="padding-bottom: 8px; padding-top: 6px;" tool="line" title="draw a line" type="button"
                class="whiteboardTool">
            ╱
        </button>
        <button tool="rect" title="draw a rectangle" type="button" class="whiteboardTool">
            <i class="far fa-square"></i>
        </button>
        <button tool="circle" title="draw a circle" type="button" class="whiteboardTool">
            <i class="far fa-circle"></i>
        </button>
        <button tool="text" title="write text" type="button" class="whiteboardTool">
            <i class="fas fa-font"></i>
        </button>
        <button tool="eraser" title="take the eraser" type="button" class="whiteboardTool">
            <i class="fa fa-eraser"></i>
        </button>
        <button id="whiteboardTrashBtn" title="Clean up the whiteboard" type="button" class="whiteboardBtn">
            <i class="fa fa-trash"></i>
        </button>
        <button style="position:absolute; left:0px; top:0px; width: 46px; display:none;"
                id="whiteboardTrashBtnConfirm" title="Confirm clear..." type="button" class="whiteboardBtn">
            <i class="fa fa-check"></i>
        </button>
        <button id="whiteboardUndoBtn" title="Undo your last step" type="button" class="whiteboardBtn">
            <i class="fa fa-undo"></i>
        </button>
    </div>

    <div class="btn-group">
        <button style="width: 190px; cursor:default;">
            <div class="activeToolIcon" style="position:absolute; top:2px; left:2px; font-size: 0.6em;"><i
                    class="fa fa-pencil-alt"></i></div>
            <img style="position: absolute; left: 11px; top: 16px; height:14px; width:130px;"
                 src="./images/slider-background.svg">
            <input title="Thickness" id="whiteboardThicknessSlider"
                   style="position: absolute; left:9px; width: 130px; top: 15px;" type="range" min="1" max="50"
                   value="3">
            <div title="Colorpicker"
                 style="position: absolute; left: 155px; top: 10px; width: 26px; height: 23px; border-radius: 3px; overflow: hidden; border: 1px solid darkgrey;">
                <div id="whiteboardColorpicker" value="#000000"
                     style="width: 40px; height: 35px; border: 0px; padding: 0px; position: relative; top: 0px; left: -5px;">
                </div>
            </div>
        </button>
    </div>

    <div class="btn-group">
        <button id="saveAsImageBtn" title="Save whiteboard as image" type="button" class="whiteboardBtn">
            <i class="fas fa-image"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-save"></i>
        </button>
        <button style="position: relative;" id="saveAsJSONBtn" title="Save whiteboard as JSON" type="button"
                class="whiteboardBtn">
            <i class="far fa-file-alt"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-save"></i>
        </button>
        <button style="position: relative;" id="saveIntoDatabase" title="Save into database" type="button"
                class="whiteboardBtn">
            <i class="fas fa-database"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-database"></i>
        </button>
        <button style="position: relative; display: none;" id="uploadWebDavBtn" title="Save whiteboard to webdav"
                type="button" class="whiteboardBtn">

            <i class="fas fa-globe"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-save"></i>
        </button>
    </div>

    <div class="btn-group">
        <button id="addImgToCanvasBtn" title="Upload Image to whiteboard" type="button" class="whiteboardBtn">
            <i class="fas fa-image"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-upload"></i>
        </button>

        <button style="position: relative;" id="uploadJsonBtn" title="Load saved JSON to whiteboard" type="button"
                class="whiteboardBtn">

            <i class="far fa-file-alt"></i>
            <i style="position: absolute; top: 3px; left: 2px; color: #000000; font-size: 0.5em; "
               class="fas fa-upload"></i>
        </button>
        <input style="display:none;" id="myFile" type="file" />

        <button id="shareWhiteboardBtn" title="share whiteboard" type="button">
            <i class="fas fa-share-square"></i>
        </button>
    </div>

    <div class="btn-group minGroup">
        <button style="width: 25px;	padding: 11px 11px;" id="minMaxBtn" title="hide buttons" type="button">
            <i id="minBtn" style="position:relative; left:-5px;" class="fas fa-angle-left"></i>
            <i id="maxBtn" style="position:relative; left:-5px; display: none;" class="fas fa-angle-right"></i>
        </button>
    </div>

</div>
</div>

</body>

</html>

