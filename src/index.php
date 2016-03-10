<html>
<head>
<title>Search Engine Collector</title>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/main.css" />
<link
	href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic,700,700italic,900,900italic&subset=latin,greek-ext,greek'
	rel='stylesheet' type='text/css'/>
</head>
<body>

	<div id="search">
		<div id='logo'>
		<span>SE Collector</span>
		</div>
		<div id='search-input'>
		<form>
		<input id="query-input" type="text" placeholder="Type your query here!"> <input id="submit" type="submit" value="Search" />
		</form>
		</div>
	</div>
	
	<div id="console">
		<input id="random" type="submit" value="Shuffle" />
		
		<div class="eng">
			<input type="checkbox" value="1" id="google" name="check1" checked="true" />		
			<label> Google </label>
		</div>
		<div class="eng">
			<input type="checkbox" value="2" id="yahoo" name="check2" checked="true" />
			<label> Yahoo </label>		
		</div>
		<div class="eng">
			<input type="checkbox" value="3" id="bing" name="check3" checked="true" />
			<label> Bing </label>		
		</div>
	</div>

	<div id="results">
	<div id="no-results">NO RESULTS</div>
	</div>
	
	<div id="loader"><div id="img-loader"></div></div>

	<script type="text/javascript">
	$(function() {
		var submit = $('#submit'),
		query = $('#query-input'),
		results = $('#results'),
		shuffle = $('#random'),
		google = $('#google'),
		yahoo = $('#yahoo'),
		bing = $('#bing');

		// Clean input
		query.val("");

	    $('#submit').on('click', function(event){
	    	event.preventDefault();
	    	var engines = {};

	    	engines['google'] = google.is(":checked") ? 1 : 0;
	    	engines['yahoo'] = yahoo.is(":checked") ? 1 : 0;
	    	engines['bing'] = bing.is(":checked") ? 1 : 0;

	    	if(!engines['google'] && !engines['yahoo'] && !engines['bing']){
				alert("You have to select at least one search engine");
		    	return;
	    	}
	    	
		    var val = query.val();

		    $.ajax({
		    	  url: "router.php",
		    	  data: {query: val, eng: engines},
		    	  type: 'POST',
		    	  beforeSend: function() { $('#loader').show(); },
		          complete: function() { $('#loader').hide(); }
		    }).done(function(res) {
			    obj = jQuery.parseJSON(res);
				console.log(obj);
			    if(obj == undefined || obj == null || obj.length == 0){
				    results.html("<div id='no-results'>NO RESULTS</div>");
			    	return;
		    	}

				var html = '';
		    	$.each(obj, function(engine, res) {
		    		  $.each(res, function(id,val) {
			    		  t = val.title;
			    		  u = val.url;
			    		  
			    		  html += "<div class='result'>" + 
			    		  "<span class='title'><a href=" + u + " target='_blank'>" 
			    		  + t +  "</a></span><span class='url'>" + 
			    		  u + "</span><span class='engine'>" + engine + "</span></div>";
			    		  
		    		  });
		    	});

		    	results.html(html);
		    });
		});

	    shuffle.on("click", function(event){
	    	event.preventDefault();

	    	var parent = $("#results");
	        var divs = parent.children();
	        while (divs.length) {
	            parent.append(divs.splice(Math.floor(Math.random() * divs.length), 1)[0]);
	        }
		});

	});
	</script>
</body>
</html>