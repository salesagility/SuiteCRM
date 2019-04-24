(function() {
    var start = '<div><table align="center" width="600px" cellspacing="7" cellpadding="0" border="0"><tr>';
    var end = '</tr></table></div><br/>';

    var lorem_long = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor fermentum nisi vitae imperdiet. Nullam libero quam, feugiat vel velit ut, luctus viverra ligula. Aenean quis malesuada elit. Curabitur hendrerit massa porta, dignissim dui nec, imperdiet mauris. Phasellus dictum ante nec volutpat interdum. Vestibulum hendrerit urna dolor, vel tempus odio convallis ornare. Integer lobortis ipsum non magna suscipit tristique. Vivamus ante tortor, ultricies eget urna non, placerat suscipit nibh.';
    var lorem_short = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor fermentum nisi vitae imperdiet. Nullam libero quam, feugiat vel velit ut, luctus viverra ligula. Aenean quis malesuada elit. Curabitur hendrerit massa porta, dignissim dui nec, imperdiet mauris. Phasellus dictum ante nec volutpat interdum.';
    var lorem_title = 'Lorem Ipsum';
    var image = '<img src="/include/SuiteEditor/ckeditor/templates/sample.jpg" width="130">';
    var image_large = '<img src="/include/SuiteEditor/ckeditor/templates/sample.jpg" width="164">';

    function content_text(text) {
        return '<p><span style="font-size:14px;">' + text + '</span></p>';
    }

    function content_header(level, text) {
        var px = '';
        if (level === 1)
            px = '32';
        else if (level === 2)
            px = '24';
        else if (level === 3)
            px = '19';
        return '<p><span style="font-size:' + px + 'px;">' + text + '</span></p>';
    }

    CKEDITOR.addTemplates( 'default', {
        imagesPath: '/include/SuiteEditor/ckeditor/templates/',
        templates: [
        {
            title: '',
            image: 'headline.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(1, lorem_title) + '</td>' + end,
        },
        {
            title: '',
            image: 'content1.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(2, lorem_title) + content_text(lorem_long) + '</td>' + end,
        },
        {
            title: '',
            image: 'content2.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif;width:50%">' + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + end,
        },
        {
            title: '',
            image: 'content3.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif;width:33%">' + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif;width:33%">' + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + end,
        },
        {
            title: '',
            image: 'image1left.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:0%">' + image + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(3, lorem_title) + content_text(lorem_short) + '</td>' + end,
        },
        {
            title: '',
            image: 'image1right.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif">'  + content_header(3, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:0%">' + image + '</td>' + end,
        },
        {
            title: '',
            image: 'image2.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:0%">' + image + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(3, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:0%">' + image + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_header(3, lorem_title) + content_text(lorem_short) + '</td>' + end,
        },
        {
            title: '',
            image: 'image3.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:33%">' + image_large +  content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:33%">' + image_large + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + '<td style="vertical-align:top; font-family:Arial,sans-serif; width:33%">' + image_large + content_header(2, lorem_title) + content_text(lorem_short) + '</td>' + end,
        },
        {
            title: '',
            image: 'footer.png',
            description: '',
            html: start + '<td style="vertical-align:top; font-family:Arial,sans-serif">' + content_text(lorem_short) + '</td>' + end,
        },
        ]
    });
})();
