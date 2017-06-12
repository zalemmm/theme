/*********************************************/
/**       Beautify Data - jQuery Plugin     **/
/**      For assistance, contact me via:    **/
/** http://www.codecanyon.net/user/gdpotter **/
/*********************************************/

(function ($) {
	// Default options
	var defaults = {
		dataType : 'csv',
		csvDelimiter : ',',
		dataSrc : '',
		sortBy : -1,
		sortDirection : 'asc',
		pageSize : 0,
		pagerSize : 3,
		currentPage : 1,
		statusText : 'Showing {1} to {2} of {3} rows.',
		sorting : true,
		loader : 'ajax-loader.gif',
		enableZebra : true,
		caseSensitive : false,
		globalFilter : '',
		filter : { }
	},
	methods = {
		// Default method
		init : function( settings ) {

			// Merge defaults with user options
			var options = $.extend(defaults, settings);
			
			// Return jQuery object to maintain chainability
			return this.each(function() {
				var $this = $(this),
					tableData = [],
					columns = [],
					$table,
					i = 0, j = 0;
				
				// Store options in the DOM so that they can be
				// accessed later by other methods.
				$this.data('options', options);
				
				// Is there a bdProgress Element already?
				if( ! $('#bdProgress').length) {
					// Build Progress Window
					$('body').append($('<img/>')
					.attr({
						'id' : 'bdProgress',
						'src' : options.loader
					})
					.css({
						'position' : 'absolute',
						'z-index' : '9999',
						'border' : 'solid 1px black'
					})
					.hide());
				}			
				
				// Show the progress window
				methods.showLoader.apply( this );
				
				// Is there already data stored?
				if ( ! $this.data('tableData')){
					
					$table = $('<table/>');
					
					// Check if we have to load data instead
					// of just reading out of the table
					if (options.dataSrc) {
						if (options.dataType.toLowerCase() == 'csv')
						{
							// Load CSV file
							$.ajax({url : options.dataSrc, async : false, success : function(data) {
								var rows = data.split('\n'); // Split data into rows
								columns = rows[0].split(options.csvDelimiter); // Load the columns
								
								// Loop through each row
								for(i=1 ; i < rows.length ; i++){
									// Only add entry if row is non-null
									if(rows[i]){
										var cols = rows[i].split(options.csvDelimiter);
										tableData[i - 1] = {} ; // Create object for this row
										// Loop through all columns
										for(j=0; j < columns.length ; j++){
											// Only add property if value is non-null
											if(cols[j]){
												tableData[i - 1][columns[j]] = cols[j];
											}
										}
									}
								}
							}});
						}
						if (options.dataType.toLowerCase() == 'json')
						{
							// Load JSON file
							$.ajax({url : options.dataSrc, async : false, success : function(data) {
								tableData = $.parseJSON(data);
								
								// Extract column names
								var fields = [];
								for(i=0;i<tableData.length;i++) {
									for(nm in tableData[i]) {
										if(typeof fields[nm] == "undefined") {
											fields[nm] = true;
											columns.push(nm);
										}
									}
								}
								
							}});
						}
					} else {
						// If a datasource is not secified,
						// load data from existing table
						
						$this.find('table tr').each(function () {
							
							tableData[i - 1] = {};
							j = 0;
							
							$(this).find('td, th').each(function () {
								if (i === 0 ) { // First row (column headers)
									columns[j] = this.innerHTML;
								} else {
									tableData[i - 1][columns[j]] = this.innerHTML;
								}
								j++;
							});
							i++;
						});
						
						$this.empty();
					}
					// Store table data and columns in the DOM
					$this.data('table-data', tableData)
						 .data('columns', columns);
					
					// Extra function that is called in the plugin
					function clearSelection() {
						if(document.selection && document.selection.empty) {
							document.selection.empty();
						} else if(window.getSelection) {
							var sel = window.getSelection();
							sel.removeAllRanges();
						}
					}
					
					// Build the header
					var $header = $('<tr/>');
					for(i=0 ; i < columns.length ; i++){
						$header.append($('<th/>')
						.text(columns[i])
						.bind('click', {sortBy : i, sorting : options.sorting}, function(event) {
							// Only do something if sorting is enabled
							if (event.data.sorting) {
								clearSelection();
								$this.beautify('sortCol', event.data.sortBy );
							}
						})
						.append($('<div/>')
						.addClass('bdSortNone')
						)
						);
					}
					
					// Build the footer
					options.statusText = options.statusText;
					
					
					// Add the header to a <thead> and add that to the table
					$table.find('thead').remove();
					$table.prepend($('<thead/>').append($header))
						  .append($('<tbody/>'));
					if (options.pageSize > 0) {
						$table.append($('<tfoot/>').append($('<tr/>').append($('<td/>')
											.attr('colSpan', columns.length)
											.append($('<div/>')
												.attr('id', 'bdFooter')
													.append($('<div/>').attr('id', 'bdStatus'))
													.append($('<div/>').attr('id', 'bdPager'))
												)
											)));
					}
					
					// Output table to the DOM
					$this.html($table);
					if (options.sortBy > -1) {
						$this.beautify('sortCol', options.sortBy, options.sortDirection, false );
					}
					methods.rebuild.apply( this );
				}
			});
		},
		sortCol : function( sortBy, sortDirection, rebuild ) {
			
			// Show loader
			methods.showLoader.apply( this );
			
			var columns = $(this).data('columns'),
			sortByNum = -1,
			sortDirectionClass;
			
			// Determine if sorting is being passed as
			// a column number or the header text
			if(typeof sortBy == 'number'){
				// If sortBy is a number
				sortByNum = sortBy;
				sortBy = columns[sortBy]; // Determine header text
			} else {
				for(var i = 0 ; i < columns.length ; i++) {
					if (sortBy == columns[i]) {
						sortByNum = i;
					}
				}
				if (sortByNum < 0) {
					// Error: Column not found
					return 0;
				}
			}
			
			// Sorting function
			function compareData(a, b) {
				var compareA = a[sortBy].toLowerCase( ),
					compareB = b[sortBy].toLowerCase( );
				if (parseFloat(compareA)) {
					if (parseFloat(compareB)) { // If compareA and compareB are numbers
						return parseFloat(compareA) - parseFloat(compareB);
					} else { return -1; } // If only compareA is a number
				} else {
					if (parseFloat(compareB)) { return 1; } // If only compareB is a number
				}
				// If compareA and compareB are both non-numerical
				if (compareA < compareB) {return -1;}
				if (compareA > compareB) {return  1;}
				return 0; // Values are the same
			}
			
			// If the sortDirection is not specified,
			// determine if the current column is the
			// column already used for sorting
			if (!sortDirection) {
				if ($(this).data('sortBy') == sortBy){
					if ($(this).data('sortDirection') == 'asc') {
						sortDirection = 'dsc';
					} else {
						sortDirection = 'asc';
					}
				} else {
					sortDirection = 'asc';
				}
			}
			
			// Sort the table data
			$(this).data('table-data').sort(compareData);
			
			// Reverse the sort if the direction is dsc
			if (sortDirection == 'dsc') {
				$(this).data('table-data').reverse();
			}
			
			// Loop through and set all headers to bdSortNone
			$('thead th').each(function(column) {
				$(this).find('div').removeClass('bdSortAsc bdSortDsc')
				.addClass('bdSortNone');
			});
			
			// Determine class based on sort direction
			if (sortDirection.toLowerCase() == 'dsc'){
				sortDirectionClass = 'bdSortDsc';
			} else {
				sortDirectionClass = 'bdSortAsc';
			}
			
			// Apply class to div of header
			$(this).data('sortBy', sortBy)
				.data('sortDirection', sortDirection)
				.find('table thead th:nth-child(' + (sortByNum + 1) + ')').find('div')
				.removeClass('bdSortNone')
				.addClass(sortDirectionClass);
			
			if (rebuild === true || rebuild === undefined  ){
				methods.rebuild.apply( this );
			}
			
		},
		
		// Rebuild method:
		// Called by init method to populate the table with
		// data, and can also be called by the user to filter
		// or otherwise alter the data output.
		rebuild : function( settings ) {
			// Show progress loader
			methods.showLoader.apply( this );
			var $this = $(this),
				$tableOutput = $('<tbody/>'),
				tableData = $this.data('table-data'),
				columns = $this.data('columns'),
				filteredData = [],
				filterEnabled = false,
				$pager = $('<ul/>'),
				i = 0,
				j = 0;
			
			var options = $.extend($this.data('options'), settings);
			
			
			// Remove existing table body
			$this.find('tbody').empty();
			
			// Was a filter specified
			if (options.globalFilter !== '') {
				filterEnabled = true;
			} else {
				for (i=0; i < columns.length; i++) {
					if ((options.filter[columns[i]]) || (options.filter[parseInt(i + 1,10)])) {
						filterEnabled = true;
						break; // No need to keep looping after it's already true
					}
				}
			}

			// Create searchString function, this function allows
			// for greater control over whether or not the search
			// term was found in the text.
			function searchString(text, term) {
				if ( ! term || term === '') {
				// If there is not search term return false
					return false;
				}
				// Check for caseSensitive
				if (options.caseSensitive) {
					if (text.search(term) > -1) { return true; }
					else { return false; }
				}
				// If not case sensitive
				if (text.toLowerCase().search(term.toLowerCase()) > -1) { return true; }
				else { return false; }
			}
			
			// Loop through table and add the IDs of rows
			// that meet the filter criteria
			for(i=0 ; i < tableData.length; i++){
				var include = false;
				if (filterEnabled) {
					for(j=0 ; j < columns.length && include === false ; j++){
						if (searchString(tableData[i][columns[j]], options.filter[columns[j]]) ||
							searchString(tableData[i][columns[j]], options.filter[parseInt(j + 1,10)]) ||
							searchString(tableData[i][columns[j]], options.globalFilter)) {
							// If the search term for this column,
							// or the master search term was found
							// mark this column to include
							include = true;
							break;
						}
					}
				}
				if (include === true || filterEnabled === false) {
					filteredData[filteredData.length] = i;
				}
			}
			
			// Loop through filtered table data and add rows
			for(i=(options.currentPage - 1) * options.pageSize, itemCount = 0 ;
					i < filteredData.length && ( itemCount < options.pageSize || options.pageSize === 0 ) ;
					i++, itemCount++){
				$tableOutput.append('<tr/>');
				for(j=0 ; j < columns.length ; j++){
					$tableOutput.find('tr:last').append($('<td/>').html(tableData[filteredData[i]][columns[j]]));
				}
				if (itemCount % 2 && options.enableZebra) {
					$tableOutput.find('tr:last').addClass('zebra');
				}
			}
			// Output new table to the DOM
			$this.find('table tbody').replaceWith($tableOutput);
			
			if (options.pageSize > 0) {
				var numPages = Math.ceil(filteredData.length/options.pageSize);
				
				// Extra function that is called in the plugin
				function buildStatus(input, currentPage, pageSize, items) {
					var currentPageSize = pageSize * currentPage;
			
					if (currentPageSize > items) {
						currentPageSize = items;
					}

					return input
						.replace(/\{1\}/g, pageSize * currentPage - pageSize + 1)
						.replace(/\{2\}/g, currentPageSize)
						.replace(/\{3\}/g, items);
				}
				
				// Update Status Area
				$this.find('#bdStatus').text(buildStatus(
											options.statusText,
											options.currentPage,
											options.pageSize,
											filteredData.length)
										);
				
				// Rebuild the pager
				if (options.pagerSize > 0) {
					j = options.currentPage - Math.floor(options.pagerSize / 2) - 1;
					if (j + Math.ceil(options.pagerSize / 2) * 2 > numPages) { j = numPages - options.pagerSize; }
					if (j < 0) { j = 0; }
					for (i=0 ; i < options.pagerSize && i < numPages ; i++, j++) {
						$pager.append($('<li/>').append($('<a/>').attr('href', 'javascript:void(0);').text(j + 1))
												.bind('click', { currentPage : j + 1 } ,function(event) {
													$this.beautify('rebuild', { currentPage : event.data.currentPage });
												}));
						if (j + 1 == options.currentPage) {
							$pager.find('li:last').find('a').addClass('active');
						}
					}
				} else {
					$pager.append($('<li/>').text('Page ' + options.currentPage));
				}
				// Add the < and > arrows
				$pager.prepend($('<li/>').append($('<a/>').attr('href', 'javascript:void(0);').text('<'))
										 .bind('click', function() {
											if ( options.currentPage > 1 ) {
												$this.beautify('rebuild', { currentPage : options.currentPage - 1 });
											}
										 }))
					  .append($('<li/>').append($('<a/>').attr('href', 'javascript:void(0);').text('>'))
										 .bind('click', function() {
											if ( options.currentPage < numPages) {
												$this.beautify('rebuild', { currentPage : options.currentPage + 1 });
											}
										 }));
				if (  options.currentPage >= numPages) {
					$pager.find('li:last').find('a').addClass('inactive');
				}
				if (  options.currentPage <= 1 ) {
					$pager.find('li:first').find('a').addClass('inactive');
				}
				

				
				$this.find('#bdPager').html($pager);
			}
			
			// Hide progress loader
			methods.hideLoader.apply( this );
		},
		showLoader : function( ) {
			var winH = $(window).height(),
			winW = $(window).width();
			
			// Set the popup window to center
			$('#bdProgress').css('top',  winH/2-$('#bdProgress').height()/2-50);
			$('#bdProgress').css('left', winW/2-$('#bdProgress').width()/2-50);
			
			//Show the progress box
			$('#bdProgress').show();
			
		},
		hideLoader : function( ) {
			$('#bdProgress').hide();		
		}
	};

	$.fn.beautify = function( method ) {
		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.beautify' );
		}
		
	};
})( jQuery );
