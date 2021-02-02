<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Responsive Table</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active"><a href="#">Responsive Table</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Basic Scenario</h4> 
            </div>
            <div class="card-body">
                <table class="tablesaw table-bordered" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th scope="col" data-tablesaw-priority="persist">Movie Title</th>
                            <th scope="col" data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                            <th scope="col" data-tablesaw-priority="2" class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: red"><canvas width="200" height="20"></canvas></div></th>
                            <th scope="col" data-tablesaw-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
                            <th scope="col" data-tablesaw-priority="4">Gross</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
                            <td>1</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>83%</td>
                            <td>$2.7B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
                            <td>2</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>88%</td>
                            <td>$2.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
                            <td>3</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>92%</td>
                            <td>$1.5B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
                            <td>4</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>96%</td>
                            <td>$1.3B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
                            <td>5</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>89%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
                            <td>6</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>78%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
                            <td>7</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>36%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
                            <td>8</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>95%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
                            <td>9</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>92%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
                            <td>10</td>
                            <td class="tablesaw-stack-block"><div style="width: 100%; min-width: 10em; background-color: blue"><canvas width="200" height="20"></canvas></div></td>
                            <td>18%</td>
                            <td>$1.0B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 

    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Sort Scenario</h4> 
            </div>
            <div class="card-body">
                <table class="tablesaw table-bordered" data-tablesaw-mode="columntoggle" data-tablesaw-sortable data-tablesaw-sortable-switch>
                    <thead>
                        <tr>
                            <th scope="col" data-tablesaw-priority="persist" data-tablesaw-sortable-col rowspan="2">Movie Title</th>
                            <th scope="col" data-tablesaw-priority="2" data-tablesaw-sortable-col data-tablesaw-sortable-default-col rowspan="2">Rank</th>
                            <th scope="col" data-tablesaw-priority="4" colspan="3">Misc</th>
                        </tr>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col style="text-align: right; text-transform: uppercase;">Year</th>
                            <th scope="col" data-tablesaw-sortable-col><abbr title="Rotten Tomato Rating">Rating</abbr></th>
                            <th scope="col" data-tablesaw-sortable-col>Gross</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
                            <td>1</td>
                            <td style="text-align: right">2009</td>
                            <td>83%</td>
                            <td>$2.7B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
                            <td>2</td>
                            <td style="text-align: right">1997-12-24</td>
                            <td>88%</td>
                            <td>$2.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
                            <td>3</td>
                            <td style="text-align: right">2012</td>
                            <td>2%</td>
                            <td>$1.5B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
                            <td>4</td>
                            <td style="text-align: right">2011</td>
                            <td>96%</td>
                            <td>$1.3B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
                            <td>5</td>
                            <td style="text-align: right">2013-01-01</td>
                            <td>89%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
                            <td>6</td>
                            <td style="text-align: right">2013-01-02</td>
                            <td>78%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
                            <td>7</td>
                            <td style="text-align: right">2011</td>
                            <td>36%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
                            <td>8</td>
                            <td style="text-align: right">2003</td>
                            <td>95%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
                            <td>9</td>
                            <td style="text-align: right">2012</td>
                            <td>92%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
                            <td>10</td>
                            <td style="text-align: right">2014</td>
                            <td>18%</td>
                            <td>$1.0B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 

    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Colspans Scenario</h4> 
            </div>
            <div class="card-body">
                <table class="tablesaw table-bordered" data-tablesaw-mode="swipe" data-tablesaw-minimap data-tablesaw-mode-switch>
                    <thead>
                        <tr>
                            <th data-tablesaw-priority="1" colspan="2">H1,2</th>
                            <th data-tablesaw-priority="3">H3</th>
                            <th data-tablesaw-priority="2" colspan="2">H4,5</th>
                            <th data-tablesaw-priority="6">H6</th>
                            <th data-tablesaw-priority="6">H7</th>
                            <th data-tablesaw-priority="6">H8</th>
                        </tr>
                        <tr>
                            <th data-tablesaw-priority="1">H1</th>
                            <th data-tablesaw-priority="3" colspan="3">H2,3,4</th>
                            <th data-tablesaw-priority="6">H5</th>
                            <th data-tablesaw-priority="6">H6</th>
                            <th data-tablesaw-priority="6">H7</th>
                            <th data-tablesaw-priority="6">H8</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td colspan="2">4,5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr data-tablesaw-ignorerow><td colspan="8">Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row Big long ignored row</td></tr>
                    </tbody>
                </table>
            </div>
        </div> 

    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Swipe Scenario</h4> 
            </div>
            <div class="card-body">
                <table class="tablesaw tablesaw-swipe" data-tablesaw-mode="swipe">
                    <thead>
                        <tr>
                            <th class="title" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gross</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
                            <td>1</td>
                            <td>2009</td>
                            <td>83%</td>
                            <td>$2.7B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
                            <td>2</td>
                            <td>1997</td>
                            <td>88%</td>
                            <td>$2.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
                            <td>3</td>
                            <td>2012</td>
                            <td>92%</td>
                            <td>$1.5B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
                            <td>4</td>
                            <td>2011</td>
                            <td>96%</td>
                            <td>$1.3B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
                            <td>5</td>
                            <td>2013</td>
                            <td>89%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
                            <td>6</td>
                            <td>2013</td>
                            <td>78%</td>
                            <td>$1.2B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
                            <td>7</td>
                            <td>2011</td>
                            <td>36%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
                            <td>8</td>
                            <td>2003</td>
                            <td>95%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
                            <td>9</td>
                            <td>2012</td>
                            <td>92%</td>
                            <td>$1.1B</td>
                        </tr>
                        <tr>
                            <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
                            <td>10</td>
                            <td>2014</td>
                            <td>18%</td>
                            <td>$1.0B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 

    </div>                    
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Column Toggle Scenario</h4> 
            </div>
            <div class="card-body">
                <div class="tablesaw-overflow">
                    <table class="tablesaw table-bordered" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="0" colspan="2">Gross</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
                                <td>1</td>
                                <td rowspan="2">2009</td>
                                <td>$2.7B</td>
                                <td>$2.7B</td>
                                <td>83%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
                                <td>2</td>
                                <td>$2.1B</td>
                                <td>$2.1B</td>
                                <td>88%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
                                <td>3</td>
                                <td>2012</td>
                                <td>$1.5B</td>
                                <td>$1.5B</td>
                                <td>92%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
                                <td>4</td>
                                <td>2011</td>
                                <td>$1.3B</td>
                                <td>$1.3B</td>
                                <td>96%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
                                <td>5</td>
                                <td>2013</td>
                                <td>$1.2B</td>
                                <td>$1.2B</td>
                                <td>89%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
                                <td>6</td>
                                <td>2013</td>
                                <td>$1.2B</td>
                                <td>$1.2B</td>
                                <td>78%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
                                <td>7</td>
                                <td>2011</td>
                                <td>$1.1B</td>
                                <td>$1.1B</td>
                                <td>36%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
                                <td>8</td>
                                <td>2003</td>
                                <td>$1.1B</td>
                                <td>$1.1B</td>
                                <td>95%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
                                <td>9</td>
                                <td>2012</td>
                                <td>$1.1B</td>
                                <td>$1.1B</td>
                                <td>92%</td>
                            </tr>
                            <tr>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
                                <td>10</td>
                                <td>2014</td>
                                <td>$1.0B</td>
                                <td>$1.0B</td>
                                <td>18%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 

    </div>                    
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Check All Scenario</h4> 
            </div>
            <div class="card-body">
                <div class="tablesaw-overflow">
                    <table class="tablesaw table-bordered" data-tablesaw>
                        <thead>
                            <tr>
                                <th scope="col"><label><input type="checkbox" data-tablesaw-checkall><span class="sr-only"> Check All</span></label></th>
                                <th scope="col">Movie Title <a href="#" data-tablesaw-checkall="#checkall-target">Toggle All Checkboxes</a> <a href="#" data-tablesaw-checkall="#checkall-target" data-tablesaw-checkall-checked>Check All</a> <a href="#" data-tablesaw-checkall="#checkall-target" data-tablesaw-checkall-unchecked>Uncheck All</a></th>
                                <th scope="col">Rank</th>
                                <th scope="col">Year</th>
                                <th scope="col"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
                                <th scope="col">Gross</th>
                            </tr>
                        </thead>
                        <tbody id="checkall-target">
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
                                <td>1</td>
                                <td>2009</td>
                                <td>83%</td>
                                <td>$2.7B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
                                <td>2</td>
                                <td>1997</td>
                                <td>88%</td>
                                <td>$2.1B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
                                <td>3</td>
                                <td>2012</td>
                                <td>92%</td>
                                <td>$1.5B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
                                <td>4</td>
                                <td>2011</td>
                                <td>96%</td>
                                <td>$1.3B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
                                <td>5</td>
                                <td>2013</td>
                                <td>89%</td>
                                <td>$1.2B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
                                <td>6</td>
                                <td>2013</td>
                                <td>78%</td>
                                <td>$1.2B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
                                <td>7</td>
                                <td>2011</td>
                                <td>36%</td>
                                <td>$1.1B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
                                <td>8</td>
                                <td>2003</td>
                                <td>95%</td>
                                <td>$1.1B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
                                <td>9</td>
                                <td>2012</td>
                                <td>92%</td>
                                <td>$1.1B</td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox"><span class="sr-only"> Select Row</span></label></td>
                                <td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
                                <td>10</td>
                                <td>2014</td>
                                <td>18%</td>
                                <td>$1.0B</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>


<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/tablesaw/tablesaw.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/tablesaw/tablesaw.js'); ?>"></script> 
<script src="<?php echo base_url('dist/vendors/tablesaw/tablesaw-init.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

