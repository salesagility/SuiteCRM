$(function() {

	// get javascript source
	$("#javascript pre").text($("#js").html());
	
	if($("#demo").size() > 0) {
		// old school chaining...
		var html = $("#demo").html()
				.toLowerCase()
				.replace(/\n|\t|\r/g,'')
				.replace(/<td/g,'\t\t\t<td')
				.replace(/<\/td>/g,'</td>\n')
				.replace(/<th/g,'\t\t\t<th')
				.replace(/<\/th>/g,'</th>\n')
				.replace(/<\/tr>/g,'\t\t</tr>')
				.replace(/<tr>/g,'\n\t\t<tr>\n')
				.replace(/<thead/g,'\n\t<thead>')
				.replace(/<\/thead>/g,'\n\t</thead>')
				.replace(/<tbody/g,'\n\t<tbody')
				.replace(/<\/tbody>/g,'\n\t</tbody>')
				.replace(/<\/table>/g,'\n</table>')
				.replace(/-->/g,'-->\n');
				
		$("#html pre").text(html);
	}
	$("pre.javascript").chili();
	$("pre.html").chili();
	$("pre.css").chili();
});