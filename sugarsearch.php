<?php
header("Content-type: text/xml");
$searchuri="{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}" . dirname($_SERVER['REQUEST_URI']). "/index.php?action=UnifiedSearch&amp;module=Home&amp;search_form=false&amp;advanced=false&amp;query_string={searchTerms}";
print <<<EOF
<?xml version="1.0" encoding="UTF-8" ?> 
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"> 
    <ShortName>SuS</ShortName>  
    <Description>Sugar Suche</Description> 
    <InputEncoding>UTF-8</InputEncoding> 
    <Image width="16" height="16">data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QsNDSQPjkEj+QAAAfNJREFUWMPN2E1u1DAUwPH/c1KJdoOKkJDFHbqo2PU03XKGLrkG4hCskFggJLbTqheoKhZDWxWWVSnxYxFn6sm4ThOXmEhWMpqJ85v3MSNbAKy1AhigAoR5DwUawC2XSxVrrXx+c+hEBFVth4A0ev9aHTgFp0jTXTtEWV0DvD/YCe4JBu1ZIu99v/51dPLt6wfgJ3BrAJOLkUZ79wSQBEZVeb37/B2wD7wAjAGqXAzOgXPRqKQw3QD2PKiqAcnHaFsMEzAe9BLYAaQGsjHSeBDjMR601TVUDU+A8UUdPmQEhrCz6/WJJmJ6KRuDCVB90HSMBJOPxqx7OlAeJvyWYzHRCD0VZqP1E5hBUBam3/YjMFFQLqb/sDGYRMqmY4ZAKcwDoDxMCjSEiacsE6NaRUGPwaRTNhHTnu94++nWF7j2Cr3259+bre8qvjy7B5lVyjIx7eTjMf0Ime6/7H/ArEWoFEb1LgYqhxFlIGUzY6I1VBLT/WRspqwQJt5lBTGOSFGXxMRrqCTGPVBDpTDRCJXF/EmB5sckIlQG41cs2lt1/AtMtfrcAAaftwZQA+jix9lRKcxHuTwGroAbQMVaWwGv/JbInl/4b82wcdVV9BVwCiyAixpwfrNoAZwD237hP8fR+Mhce4OTyJaemXlLz4Vben8BBP/7vnr9w0kAAAAASUVORK5CYII=</Image> 
    <Url type="text/html" template="{$searchuri}"/>
</OpenSearchDescription>
EOF;
