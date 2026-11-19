
sessionStorage.setItem("StartTime", new Date().toLocaleString('en', {timeZone: 'America/Santiago'}) );
DivLoadingState('main');
globalThis.RefreshIntervals_Ids = [];
globalThis.UrlBase =  "https://smartbox.eco3.cl"; 
globalThis.appModel =  new Model(); 
await globalThis.appModel.init();
globalThis.ThisApp= new AppSmartbox();

ThisApp.init();











