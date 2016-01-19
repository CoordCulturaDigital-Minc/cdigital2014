function customSearch()
{
	var searchControl = new google.search.CustomSearchControl( '011992066558973672330:z5afzfgc19a' );
	var options       = new google.search.DrawOptions();

	options.enableSearchResultsOnly();

	searchControl.setResultSetSize( google.search.Search.FILTERED_CSE_RESULTSET );

	searchControl.draw( 'cse', options );

	var queryFromUrl = parseQueryFromUrl();

	if( queryFromUrl )
	{
		searchControl.execute( queryFromUrl );
	}
}

function parseQueryFromUrl()
{
	var queryParamName = "s";
	var search = window.location.search.substr( 1 );
	var parts  = search.split( '&' );
	for( var i = 0; i < parts.length; i++ )
	{
		var keyvaluepair = parts[ i ].split( '=' );
		if( decodeURIComponent( keyvaluepair[ 0 ] ) == queryParamName )
		{
			return decodeURIComponent( keyvaluepair[ 1 ].replace( /\+/g, ' ' ) );
		}
	}
	return '';
}

google.load( 'search', '1', { language : 'pt-BR', style : google.loader.themes.MINIMALIST } );

google.setOnLoadCallback( customSearch, true );