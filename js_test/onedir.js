var segs = [];
$(".seg-begin").each(function (idx, node) {
 segs.push(node)
 var link = $("<a></a>").attr("href", "#" + $(node).attr("name")).html($(node).children("h1").html())
 if (!idx) {
  link.addClass("active")
 }
 var row = $("<li></li>").append(link)
 $("#toc ul").append(row)
})


$(window).bind("scroll", function() {
    var scrollTop = $(this).scrollTop()
    var topSeg = null
    for (var idx in segs) {
     var seg = segs[idx]
     if (seg.offsetTop > scrollTop) {
      continue
     }
     if (!topSeg) {
      topSeg = seg
     } else if (seg.offsetTop >= topSeg.offsetTop) {
      topSeg = seg
     }
    }
    if (topSeg) {
     $("#toc a").removeClass("active")
     var link = "#" + $(topSeg).attr("name")
     console.log('#toc a[href="' + link + '" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" ]')
     $('#toc a[href="' + link + '" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" ]').addClass("active")
     // console.log($(topSeg).children("h1").text())
    }
   })