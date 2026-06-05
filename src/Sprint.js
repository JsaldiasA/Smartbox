

    async function GetMainSprint(  )
	{	
		RefreshIntervals_Ids.forEach(interval_ID => {

		 clearInterval(interval_ID)

		});	


		 document.getElementById('main').innerHTML = `    <div class="container">
        <div class="row pb-3">
            <div class="col p-3 card shadow p-3 card shadow">
              <iframe src="https://docs.google.com/spreadsheets/d/1u6N9Kf1icpXGGutgmdJMsdKN_3U7vZC-/edit?usp=sharing&ouid=108650448787646658808&rtpof=true&sd=true" width="100%" height="1000">
                </iframe>
            </div>        
        </div>
    </div>`;

	}
	
	