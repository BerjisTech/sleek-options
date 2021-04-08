<div style="display: flex; flex-direction: row; width: 100vw; height: 100vh; overflow-y: hidden; overflow-x: hidden;">
    <div style="height: 100vh; overflow-y: scroll;">
        <?php
        $blocks = array(
            'layout', 'templates', 'sections', 'snippets', 'assets', 'config', 'locale'
        );
        foreach ($blocks as $block) : ?>
            <div class="tile">
                <span class="block-title"><?php echo $block; ?></span>
                <?php foreach ($files as $file) : ?>
                    <?php if (strpos($file['key'], $block) !== false) : ?>
                        <span class="file" onclick="pullFile('<?php echo $file['key']; ?>')"><?php echo $file['key']; ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div style="flex-grow: 4;">
        <div class="file-name " style="font-size: 16px; color: #000000; font-weight: 700; padding:10px 5px;">No file selected</div>
        <div id="editor">

        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/ace-builds/src-noconflict/ace.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/chrome");
    editor.session.setMode("ace/mode/ruby");

    function pullFile(file) {
        $('.file-name').html('<img src="<?php echo base_url('assets/images/loader.gif'); ?>" style="height: 10vh;"/>');
        $('.file-name').addClass('text-center')
        $.ajax({
            url: '<?php echo base_url('specific_file/' . $theme . '/' . $shop . '/' . $token); ?>',
            method: 'POST',
            data: {
                'file': file
            },
            success: (d) => {
                editor.setValue(d);
                editor.getSession().getUndoManager().reset();
                $('.file-name').removeClass('text-center')
                $('.file-name').html(file);
            },
            error: (d) => {
                editor.setValue(d);
                editor.getSession().getUndoManager().reset();
                $('.file-name').removeClass('text-center')
                $('.file-name').html('error');
            }
        })
    }
</script>


<style type="text/css" media="screen">
    html,
    body,
    .main-content {
        width: 100vw;
        height: 100vh;
        overflow-y: hidden;
        overflow-x: hidden;
        margin: 0px !important;
        padding: 0px !important;
    }

    .tile {
        background: #FFFFFF;
        border-radius: 5px;
        box-shadow: inset 0px 0px 10px #eeeeee;
        margin-bottom: 10px;
        padding: 10px;
    }

    .file {
        display: table;
        padding: 5px;
        cursor: pointer;
    }

    .block-title {
        font-size: 16px;
        font-weight: 700;
        color: #000000;
    }

    #editor {
        height: 95vh;
    }
</style>