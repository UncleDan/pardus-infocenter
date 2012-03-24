/* NOTE: These files were taken from the combat logging pages and ripped
         completely, with the "var cr = " line removed and the last line
         replaced by the new line... there is no reason to try to do this
         yourself, thankfully. */

function extractId(id)
{
    if (id.indexOf('|') > 0) {
        id = id.substring(0, id.indexOf('|'));
    }
    return id;
}
var wtype1 = new Object();
var wtype2 = new Object();
var windices1 = new Array();
var windices2 = new Array();
var p = 0;
var wstats1 = new Object();
var wstats2 = new Object();
var damages;
var shots;
var stats1 = new Object();
var stats2 = new Object();
var det_stats1 = "";
var det_stats2 = "";

function extractDamage(dmg)
{
    damages = new Object();
    damages["hull"] = 0;
    damages["armor"] = 0;
    damages["shield"] = 0;
    z = dmg.indexOf(' ');
    tmp = dmg.substring(0, z);
    type = dmg.substr(z+1, 4);
    if (type == "hull")
        damages["hull"] = tmp;
    else if (type == "armo")
        damages["armor"] = tmp;
    else
        damages["shield"] = tmp;
    while (dmg.indexOf(',') > 0) {
        dmg = dmg.substr(dmg.indexOf(',')+2);
        z = dmg.indexOf(' ');
        tmp = dmg.substring(0, z);
        type = dmg.substr(z+1, 4);
        if (type == "hull")
            damages["hull"] = tmp;
        else if (type == "armo")
            damages["armor"] = tmp;
        else
            damages["shield"] = tmp;
    }
    return damages;
}

function extractRate(id)
{
    if (id.indexOf('|') > 0) {
        rate = id.substr(id.indexOf('|')+1);
    } else {
        rate = 0;
    }
    return rate;
}

function inArray(search, arr)
{
    for (z = 0; z < arr.length; z++) {
        if (arr[z] == search)
            return z;
    }
    return -1;
}
cr = cr.split(";");
var cr_size = cr.length;
var shipsa = new Array();
var modulesa = new Array();
var i = 0;
var j = 0;
while (cr[i] != 'B') {
    shipsa[j] = new Object();
    shipsa[j]["name"] = cr[i];
    shipsa[j]["hull"] = cr[i+1];
    shipsa[j]["armor"] = cr[i+2];
    shipsa[j]["shield"] = cr[i+3];
    i = i + 4;
    j++;
}
var shipsa_size = shipsa.length;
i++;
j = 0;
while (cr[i] != 'A') {
    modulesa[j] = new Object();
    modulesa[j]["name"] = cr[i];
    modulesa[j]["hull"] = cr[i+1];
    modulesa[j]["armor"] = cr[i+2];
    modulesa[j]["shield"] = cr[i+3];
    i = i + 4;
    j++;
}
var modulesa_size = modulesa.length;
i++;
var weapons1 = "";
var weapons2 = "";
var w1 = new Object();
var w2 = new Object();
hits1 = new Array();
hits2 = new Array();
while (cr[i] != 'B') {
    if (cr[i] == 'L' || cr[i] == 'M') {
        id = extractId(cr[i+1]);
        if (cr[i] == 'L')
            weapons1 += cr[i+2] + " x" + shipsa_size + "<br>";
        else
            weapons1 += cr[i+2] + "<br>";
        w1[id] = cr[i+2];
        if (inArray(id, windices1) == -1) {
            wtype1[id] = new Object();
            wtype1[id]["type"] = cr[i];
            wtype1[id]["rate"] = extractRate(cr[i+1]);
            windices1[p] = id;
            p++;
            wtype1[id]["shots"] = 1;
        } else {
            wtype1[id]["shots"]++;
        }
    }
    i++;
}
i++;
p = 0;
while (cr[i] != "R1" && cr[i] != 'E') {
    if (cr[i] == 'L' || cr[i] == 'M') {
        id = extractId(cr[i+1]);
        if (cr[i] == 'L')
            weapons2 += cr[i+2] + " x" + modulesa_size + "<br>";
        else
            weapons2 += cr[i+2] + "<br>";
        w2[id] = cr[i+2];
        if (inArray(id, windices2) == -1) {
            wtype2[id] = new Object();
            wtype2[id]["type"] = cr[i];
            wtype2[id]["rate"] = extractRate(cr[i+1]);
            windices2[p] = id;
            p++;
            wtype2[id]["shots"] = 1;
        } else {
            wtype2[id]["shots"]++;
        }
    }
    i++;
}
for (p = 0; p < windices1.length; p++) {
    wstats1[windices1[p]] = new Object();
    wstats1[windices1[p]]["hits"] = 0;
    wstats1[windices1[p]]["hull"] = 0;
    wstats1[windices1[p]]["armor"] = 0;
    wstats1[windices1[p]]["shield"] = 0;
}
for (p = 0; p < windices2.length; p++) {
    wstats2[windices2[p]] = new Object();
    wstats2[windices2[p]]["hits"] = 0;
    wstats2[windices2[p]]["hull"] = 0;
    wstats2[windices2[p]]["armor"] = 0;
    wstats2[windices2[p]]["shield"] = 0;
}
var round = 2;
while (cr[i] != 'E') {
    i = i + 2;
    hits1[round-2] = "";
    while (cr[i] != "S2" && cr[i].charAt(0) != 'R' && cr[i] != 'E') {
        hits1[round-2] += "<font color='green'>Hit with " + w1[cr[i]] + " for: " + cr[i+1] + "</font><br>";
        wstats1[cr[i]]["hits"]++;
        damages = extractDamage(cr[i+1]);
        if(isNaN(parseInt(damages["hull"]))) /* Fix by Bsg, thanks!! */
          {wstats1[cr[i]]["hull"] += parseInt(damages["hull"].substr(1));}
            else
              {wstats1[cr[i]]["hull"] += parseInt(damages["hull"]);}
        if(isNaN(parseInt(damages["armor"])))
          {wstats1[cr[i]]["armor"] += parseInt(damages["armor"].substr(1));}
            else
              {wstats1[cr[i]]["armor"] += parseInt(damages["armor"]);}
        if(isNaN(parseInt(damages["shield"])))
          {wstats1[cr[i]]["shield"] += parseInt(damages["shield"].substr(1));}
            else
              {wstats1[cr[i]]["shield"] += parseInt(damages["shield"]);}
        i = i + 2;
    }
    if (cr[i] == 'E') {
        hits2[round-2] = "";
        break;
    }
    if (cr[i].charAt(0) == 'R') {
        hits2[round-2] = "";
        round++;
        continue;
    }
    i++;
    hits2[round-2] = "";
    while (cr[i].charAt(0) != 'R' && cr[i] != 'E') {
        hits2[round-2] += "<font color='green'>Hit with " + w2[cr[i]] + " for: " + cr[i+1] + "</font><br>";
        wstats2[cr[i]]["hits"]++;
        damages = extractDamage(cr[i+1]);
        if(isNaN(parseInt(damages["hull"])))  /* Fix by Bsg, thanks!! */
          {wstats2[cr[i]]["hull"] += parseInt(damages["hull"].substr(1));}
            else
              {wstats2[cr[i]]["hull"] += parseInt(damages["hull"]);}
        if(isNaN(parseInt(damages["armor"])))
          {wstats2[cr[i]]["armor"] += parseInt(damages["armor"].substr(1));}
            else
              {wstats2[cr[i]]["armor"] += parseInt(damages["armor"]);}
        if(isNaN(parseInt(damages["shield"])))
          {wstats2[cr[i]]["shield"] += parseInt(damages["shield"].substr(1));}
            else
              {wstats2[cr[i]]["shield"] += parseInt(damages["shield"]);}
        i = i + 2;
    }
    round++;
}
i++;
j = 0;
var shipsb = new Array();
while (cr[i] != 'F') {
    if (cr[i] == 'D') {
        shipsb[j] = new Object();
        shipsb[j]["hull"] = 0;
        shipsb[j]["armor"] = 0;
        shipsb[j]["shield"] = 0;
        i = i + 1;
    } else {
        if (i + 2 >= cr_size)
            break;
        shipsb[j] = new Object();
        shipsb[j]["hull"] = cr[i];
        shipsb[j]["armor"] = cr[i+1];
        shipsb[j]["shield"] = cr[i+2];
        i = i + 3;
    }
    j++;
}
i++;
j = 0;
var modulesb = new Array();
while (i < cr_size) {
    if (cr[i] == 'D') {
        modulesb[j] = new Object();
        modulesb[j]["hull"] = 0;
        modulesb[j]["armor"] = 0;
        modulesb[j]["shield"] = 0;
        i = i + 1;
    } else {
        if (i + 2 >= cr_size)
            break;
        modulesb[j] = new Object();
        modulesb[j]["hull"] = cr[i];
        modulesb[j]["armor"] = cr[i+1];
        modulesb[j]["shield"] = cr[i+2];
        i = i + 3;
    }
    j++;
}

var complete = "<table width='660' border='0' cellspacing='2' cellpadding='2' class='messagestyle' style='background:url(file://c:/pardus/images/bgdark.gif)'>";
complete += "<tr><th colspan='4'>Confrontation in Trinity Space Port [8,6]</th></tr><tr><td colspan='2' align='center' valign='top'><table><tr><td><font color='#FFFFFF'><b>" + shipsa_size + " ship(s)</b></font></td></tr>";
if (shipsa_size > 0) {
    for (j = 0; j < shipsa_size; j++) {
        complete += "<tr><td><b>" + shipsa[j]["name"] + "</b><br>Hull: " + shipsa[j]["hull"] + "&#160;&#160;&#160;Armor: " + shipsa[j]["armor"] + "&#160;&#160;&#160;Shield: " + shipsa[j]["shield"] + "</td></tr>";
    }
}
complete += "</table></td><td colspan='2' align='center' valign='top'><table><tr><td><font color='#FFFFFF'><b>" + modulesa_size + " ship(s)</b></font></td></tr>";
if (modulesa_size > 0) {
    for (j = 0; j < modulesa_size; j++) {
        complete += "<tr><td><b>" + modulesa[j]["name"] + "</b><br>Hull: " + modulesa[j]["hull"] + "&#160;&#160;&#160;Armor: " + modulesa[j]["armor"] + "&#160;&#160;&#160;Shield: " + modulesa[j]["shield"] + "</td></tr>";
    }
}
complete += "</table></td></tr>";
complete += "<tr><th colspan='4'>Weapons used</th></tr>";
complete += "<tr><td colspan='2' align='center' valign='top'><table><tr><td>" + weapons1 + "</td></tr></table></td><td colspan='2' align='center' valign='top'><table><tr><td>" + weapons2 + "</td></tr></table></td></tr>";
complete += "<tr><th colspan='4'>Resulting Ship / Module Conditions</th></tr>";
complete += "<tr><td colspan='2' align='center' valign='top'><table>";
var shipsb_size = shipsb.length;
var destroyed_ships = 0;
for (j = 0; j < shipsb_size; j++) {
    if (shipsb[j]["hull"] == 0)
        destroyed_ships++;
}
if (destroyed_ships > 0) {
    complete += "<tr><td><b><font color='red'>" + destroyed_ships + " ship(s) have been destroyed.</font></b></td></tr>";
}
if (shipsb_size > 0) {
    for (j = 0; j < shipsb_size; j++) {
        hull = shipsb[j]["hull"];
        diff = shipsa[j]["hull"] - hull;
        if (diff > 0) {
            hull += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            hull += " (change: <font color='green'>+" + diff + "</font>)";
        }
        armor = shipsb[j]["armor"];
        diff = shipsa[j]["armor"] - armor;
        if (diff > 0) {
            armor += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            armor += " (change: <font color='green' title='Robots'>+" + diff + "</font>)";
        }
        shield = shipsb[j]["shield"];
        diff = shipsa[j]["shield"] - shield;
        if (diff > 0) {
            shield += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            shield += " (change: <font color='green' title='Charge'>+" + diff + "</font>)";
        }
        complete += "<tr><td><b>" + shipsa[j]["name"] + "</b><br>Hull: " + hull + "&#160;&#160;&#160;Armor: " + armor + "&#160;&#160;&#160;Shield: " + shield + "</td></tr>";
    }
}
complete += "</table></td><td colspan='2' align='center' valign='top'><table>";
var modulesb_size = modulesb.length;
var destroyed_modules = 0;
for (j = 0; j < modulesb_size; j++) {
    if (modulesb[j]["hull"] == 0)
        destroyed_modules++;
}
if (destroyed_modules > 0) {
    complete += "<tr><td><b><font color='red'>" + destroyed_modules + " ship(s) have been destroyed.</font></b></td></tr>";
}
if (modulesb_size > 0) {
    for (j = 0; j < modulesb_size; j++) {
        hull = modulesb[j]["hull"];
        diff = modulesa[j]["hull"] - hull;
        if (diff > 0) {
            hull += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            hull += " (change: <font color='green'>+" + diff + "</font>)";
        }
        armor = modulesb[j]["armor"];
        diff = modulesa[j]["armor"] - armor;
        if (diff > 0) {
            armor += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            armor += " (change: <font color='green' title='Robots'>+" + diff + "</font>)";
        }
        shield = modulesb[j]["shield"];
        diff = modulesa[j]["shield"] - shield;
        if (diff > 0) {
            shield += " (change: <font color='red'>-" + diff + "</font>)";
        } else if (diff < 0) {
            diff = diff * (-1);
            shield += " (change: <font color='green' title='Charge'>+" + diff + "</font>)";
        }
        complete += "<tr><td><b>" + modulesa[j]["name"] + "</b><br>Hull: " + hull + "&#160;&#160;&#160;Armor: " + armor + "&#160;&#160;&#160;Shield: " + shield + "</td></tr>";
    }
}
complete += "</table></td></tr>";
var hits1_size = hits1.length;
var hits2_size = hits2.length;
complete += "<tr><th colspan='4' class='premium'><a href='http://www.pardus.at/index.php?section=premiumfeatures' target='_blank'>Statistics</a></th></tr>";
complete += "<tr><td colspan='2' align='center' valign='top' width='50%'>";

stats1["hits"] = 0;
stats1["hitsm"] = 0;
stats1["shots"] = 0;
stats1["shotsm"] = 0;
stats1["hull"] = 0;
stats1["hullm"] = 0;
stats1["armor"] = 0;
stats1["armorm"] = 0;
stats1["shield"] = 0;
stats1["shieldm"] = 0;
for (p = 0; p < windices1.length; p++) {
    if (wtype1[windices1[p]]["type"] == 'L') {
        stats1["hits"] += wstats1[windices1[p]]["hits"];
        det_shots = hits1_size * shipsa_size * wtype1[windices1[p]]["rate"] * wtype1[windices1[p]]["shots"];
        det_shots = parseInt(det_shots);
        stats1["shots"] += det_shots;
        stats1["hull"] += wstats1[windices1[p]]["hull"];
        stats1["armor"] += wstats1[windices1[p]]["armor"];
        stats1["shield"] += wstats1[windices1[p]]["shield"];
        if (hits1_size * wtype1[windices1[p]]["rate"] == 0)
            det_ratio = "N/A";
        else
            det_ratio = Math.round(wstats1[windices1[p]]["hits"] / det_shots * 10000) / 100;
    } else {
        stats1["hitsm"] += wstats1[windices1[p]]["hits"];
        det_shots = wtype1[windices1[p]]["shots"];
        stats1["shotsm"] += det_shots;
        stats1["hullm"] += wstats1[windices1[p]]["hull"];
        stats1["armorm"] += wstats1[windices1[p]]["armor"];
        stats1["shieldm"] += wstats1[windices1[p]]["shield"];
        det_ratio = Math.round((wstats1[windices1[p]]["hits"] / det_shots) * 10000) / 100;
    }
    det_stats1 += "<tr><td>" + w1[windices1[p]] + "</td><td align='right'>" + wstats1[windices1[p]]["hits"] + "</td><td align='right'>" + det_shots + "</td><td align='right'>" + det_ratio + "%</td><td align='right'>" + wstats1[windices1[p]]["hull"] + "</td><td align='right'>" + wstats1[windices1[p]]["armor"] + "</td><td align='right'>" + wstats1[windices1[p]]["shield"] + "</td><td align='right'></td></tr>";
}
if (stats1["shots"] == 0)
    stats1["ratio"] = "N/A";
else
    stats1["ratio"] = Math.round(stats1["hits"] / stats1["shots"] * 10000) / 100;
if (stats1["shotsm"] == 0)
    stats1["ratiom"] = "N/A";
else
    stats1["ratiom"] = Math.round(stats1["hitsm"] / stats1["shotsm"] * 10000) / 100;
complete += "<table width='100%' class='premium'><tr><th width='200'>Weapon</th><th>Hits</th><th>Shots</th><th width='100'>Ratio</th><th colspan='3'  width='33%'>Damage</th></tr>";
complete += "<tr><td colspan='4'>&#160;</td><th width='11%'><font size='1'>Hull</font></th><th width='11%'><font size='1'>Armor</font></th><th width='11%'><font size='1'>Shield</font></th></tr>";
complete += "<tr><td nowrap>Total <font size='1'>(Guns)</font></td><td align='right'>" + stats1["hits"] + "</td><td align='right'>" + stats1["shots"] + "</td><td align='right'>" + stats1["ratio"] + "%</td><td align='right'>" + stats1["hull"] + "</td><td align='right'>" + stats1["armor"] + "</td><td align='right'>" + stats1["shield"] + "</td></tr>";
complete += "<tr><td nowrap>Total <font size='1'>(Missiles)</font></td><td align='right'>" + stats1["hitsm"] + "</td><td align='right'>" + stats1["shotsm"] + "</td><td align='right'>" + stats1["ratiom"] + "%</td><td align='right'>" + stats1["hullm"] + "</td><td align='right'>" + stats1["armorm"] + "</td><td align='right'>" + stats1["shieldm"] + "</td></tr>";
complete += det_stats1 + "</table>";

complete += "</td><td colspan='2' align='center' valign='top' width='50%'>";
stats2["hits"] = 0;
stats2["hitsm"] = 0;
stats2["shots"] = 0;
stats2["shotsm"] = 0;
stats2["hull"] = 0;
stats2["hullm"] = 0;
stats2["armor"] = 0;
stats2["armorm"] = 0;
stats2["shield"] = 0;
stats2["shieldm"] = 0;
for (p = 0; p < windices2.length; p++) {
    if (wtype2[windices2[p]]["type"] == 'L') {
        stats2["hits"] += wstats2[windices2[p]]["hits"];
        det_shots = hits2_size * modulesa_size * wtype2[windices2[p]]["rate"] * wtype2[windices2[p]]["shots"];
        stats2["shots"] += det_shots;
        stats2["hull"] += wstats2[windices2[p]]["hull"];
        stats2["armor"] += wstats2[windices2[p]]["armor"];
        stats2["shield"] += wstats2[windices2[p]]["shield"];
        if (hits2_size * wtype2[windices2[p]]["rate"] == 0)
            det_ratio = "N/A";
        else
            det_ratio = Math.round(wstats2[windices2[p]]["hits"] / (det_shots) * 10000) / 100;
    } else {
        stats2["hitsm"] += wstats2[windices2[p]]["hits"];
        det_shots = wtype2[windices2[p]]["shots"];
        stats2["shotsm"] += det_shots;
        stats2["hullm"] += wstats2[windices2[p]]["hull"];
        stats2["armorm"] += wstats2[windices2[p]]["armor"];
        stats2["shieldm"] += wstats2[windices2[p]]["shield"];
        det_ratio = Math.round((wstats2[windices2[p]]["hits"] / det_shots) * 10000) / 100;
    }
    det_stats2 += "<tr><td><font size='1'>" + w2[windices2[p]] + "</font></td><td align='right'>" + wstats2[windices2[p]]["hits"] + "</td><td align='right'>" + det_shots + "</td><td align='right'>" + det_ratio + "%</td><td align='right'>" + wstats2[windices2[p]]["hull"] + "</td><td align='right'>" + wstats2[windices2[p]]["armor"] + "</td><td align='right'>" + wstats2[windices2[p]]["shield"] + "</td></tr>";
}
if (stats2["shots"] == 0)
    stats2["ratio"] = "N/A";
else
    stats2["ratio"] = Math.round(stats2["hits"] / stats2["shots"] * 10000) / 100;
if (stats2["shotsm"] == 0)
    stats2["ratiom"] = "N/A";
else
    stats2["ratiom"] = Math.round(stats2["hitsm"] / stats2["shotsm"] * 10000) / 100;
complete += "<table width='100%' class='premium'><tr><th width='200'>Weapon</th><th>Hits</th><th>Shots</th><th width='100'>Ratio</th><th colspan='3' width='33%'>Damage</th></tr>";
complete += "<tr><td colspan='4'>&#160;</td><th width='11%'><font size='1'>Hull</font></th><th width='11%'><font size='1'>Armor</font></th><th width='11%'><font size='1'>Shield</font></th></tr>";
complete += "<tr><td nowrap>Total <font size='1'>(Guns)</font></td><td align='right'>" + stats2["hits"] + "</td><td align='right'>" + stats2["shots"] + "</td><td align='right'>" + stats2["ratio"] + "%</td><td align='right'>" + stats2["hull"] + "</td><td align='right'>" + stats2["armor"] + "</td><td align='right'>" + stats2["shield"] + "</td></tr>";
complete += "<tr><td nowrap>Total <font size='1'>(Missiles)</font></td><td align='right'>" + stats2["hitsm"] + "</td><td align='right'>" + stats2["shotsm"] + "</td><td align='right'>" + stats2["ratiom"] + "%</td><td align='right'>" + stats2["hullm"] + "</td><td align='right'>" + stats2["armorm"] + "</td><td align='right'>" + stats2["shieldm"] + "</td></tr>";
complete += det_stats2 + "</table>";

complete += "</td></tr>";
complete += "<tr><th colspan='4'>Combat Report: Squadron vs Squadron</th></tr>";
var r = 0;
for (var x = 0; x < hits1_size; x++) {
    r++;
    complete += "<tr><th width='5'>" + r + "</th><td valign='top' width='50%'><table><tr><td>" + hits1[x] + "</td></tr></table></td>";
    complete += "<th width='5'>" + r + "</th><td valign='top' width='50%'><table><tr><td>" + hits2[x] + "</td></tr></table></td>";
}
complete += "</table>";

var reportHtml = complete;
