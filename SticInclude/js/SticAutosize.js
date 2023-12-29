// run autosize
function runCheckIntervalToAutosize() {
  var checkIfPageIsFullyLoaded = setInterval(function () {
    if (SUGAR_callsInProgress === 0) {

      // excepciones autosize
      var exceptionsSelectors = [];
      // any textarea inside no-autosize class selector
      exceptionsSelectors.push('.no-autosize textarea'); 

      exceptionsSelectors.forEach(element => {
        $(element).addClass('no-autosize')
      });

      autosize($("textarea:not(.no-autosize)"));
      clearInterval(checkIfPageIsFullyLoaded);
    }
  }, 300);
}
runCheckIntervalToAutosize();

