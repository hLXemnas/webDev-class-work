object xml{
	def countimages(cont:String): Int = {
		var linki = "<img.+?src=\"(.+?)\".*".r
		val num = linki.findAllIn(cont).matchData.toList.size
		return num
	}
	def countfromlink(url:String): Int = {
		try{
		val content = io.Source.fromURL(url)("UTF-8")..mkString
		var linki = "<img.+?src=\"(.+?)\".*".r
		val num = linki.findAllIn(content).matchData.toList.size
		return num
		} catch{
			case _: Throwable => 0
		}

	}
	def taska{
		println("URL? with protocol, gets scripts and images")
		val url = scala.io.StdIn.readLine()
		val t1 = System.currentTimeMillis()
		val content = io.Source.fromURL(url)("UTF-8").mkString
		val scriptr = "(?i)<script.*</script>".r
		val numscripts = scriptr.findAllIn(content).matchData.toList.size
		val numimg = countimages(content)
		println(s"number of script tags $numscripts")
		println(s"number of images $numimg")
	}
	def task2: Long = {
		println("URL? with protocol, gets images from linked sites, serial")
		var count:Int = 0
		val url = scala.io.StdIn.readLine()
		val t1 = System.currentTimeMillis()
		val content = io.Source.fromURL(url)("UTF-8").mkString
		//val x = scala.xml.XML.loadString(content)
		val linkr = "<a.+?href=\"(http.+?)\".*?>(.+?)</a>".r
		val htr = "(http.+?)(s)?([^\'\" >]+)".r
		val linktags = linkr.findAllIn(content).toList
		for(x <- linktags){
			val html = htr.findAllIn(x).toList
			for(y <- html){
				println(y)
				val img = countfromlink(y.trim)
				println(img)
				if(img > 2){
					count = count + 1 
				}
			}
		}
		val t2 = System.currentTimeMillis()
		println("serial execution time= " + (t2 - t1))
		println(s"number of pages with more than two image: $count")
		return (t2-t1)
	}
	def task2d: Long = {
		println("URL? with protocol, gets images from linked sites, parallel")
		var count:Int = 0
		val url = scala.io.StdIn.readLine()
		val t1 = System.currentTimeMillis()
		val content = io.Source.fromURL(url)("UTF-8").mkString
		//val x = scala.xml.XML.loadString(content)
		val linkr = "<a.+?href=\"(http.+?)\".*?>(.+?)</a>".r
		val htr = "(http.+?)(s)?([^\'\" >]+)".r
		val linktags = linkr.findAllIn(content).toList.par
		for(x <- linktags){
			val html = htr.findAllIn(x).toList
			for(y <- html){
				println(y)
				val img = countfromlink(y.trim)
				println(img)
				if(img > 2){
					count = count + 1 
				}
			}
		}
		val t2 = System.currentTimeMillis()
		println("parallel execution time= " + (t2 - t1))
		println(s"number of pages with more than two image: $count")
		return (t2 - t1)
	}
	def main(args:Array[String]){
		taska
		val ser = task2
		val par = task2d
		println("time saved by parrallel is: " + (ser - par))
	}
}