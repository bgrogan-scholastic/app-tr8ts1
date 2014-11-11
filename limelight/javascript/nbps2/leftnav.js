var default_cat=""; 

default_cat = ''; 
var imagepath = "/images/nbps2/sciclopedia/"
var catname="";

var categoryData = new Array();
var headImg      = new Image(755, 25);
var bannerImg    = new Image(609, 106);
var topnavImg    = new Image(64, 22);
var leftnavImg   = new Image(141, 18); 

function category(name, id, index) {
  this.name  = name;
  this.id    = id;
  this.index = index; 
}

categoryData[0]  = new category("animal",  'a', 0);
categoryData[1]  = new category("astro",   's', 1);
categoryData[2]  = new category("bio",     'b', 2);
categoryData[3]  = new category("chem",    'c', 3);
categoryData[4]  = new category("earth",   'r', 4);
categoryData[5]  = new category("energy",  'e', 5);
categoryData[6]  = new category("enviro",  'n', 6);
categoryData[7]  = new category("human",   'h', 7);
categoryData[8]  = new category("math",    'm', 8);
categoryData[9]  = new category("past",    'u', 9);
categoryData[10] = new category("physics", 'f', 10);
categoryData[11] = new category("plant",   'p', 11);
categoryData[12] = new category("tech",    't', 12);
categoryData[13] = new category("home",    'home', 13);
 
function setImages() {
 // var catname = "";
	//alert(default_cat);
  // Grab the name of the category we are using
  for (i = 0; i < 14; i++) {
    if (categoryData[i].id == default_cat)
      catname = categoryData[i].name;
  }

  headImg.src    = imagepath + "head_" + catname + ".gif";
  bannerImg.src  = imagepath + "banner_" + catname + ".gif";
  topnavImg.src  = imagepath + "nav_top_img_" + catname + ".gif";
  leftnavImg.src = imagepath + "nav_left_" + default_cat + "_b.gif";
  
  document.head.src    = headImg.src;
  document.banner.src  = bannerImg.src;
  document.nav_top.src = topnavImg.src;
  
  if (default_cat != "home")
    eval("document.leftnav_" + default_cat + ".src=leftnavImg.src");  
}

function doMouseCatButton(cat, name) {
  for (i = 0; i < 14; i++) {
    if (categoryData[i].id == cat)
      catid = categoryData[i].id;
  }

  if (cat != default_cat) {
    leftnavImg.src = imagepath + "nav_left_" + catid + "_" + name + ".gif";
    eval("document.leftnav_" + catid + ".src=leftnavImg.src");  
  }
}
