$(document).ready(function(){


  //Afficher/masquer le tableau
  $('#afficher2').click(function(){
    $('#tableau2').toggle('fast');
    $('#button_line2').toggle('fast');
  });

  //Récuperation des playlists depuis la BDD
  $.ajax({
    url:ajaxurl,
    data:{
      'action':'recuperer_playlists',
    },
    dataType: 'JSON',
    success: function(data){
      //console.log(data);
      let ligne;
      let compteur=1;
      // Création tableau de playlists
      $.each(data,function(key,value){

        ligne+='<tr id="tr'+compteur+'"><td><label><input type="checkbox" name="fooo"></label></td>';
        ligne+='<td name="titre">'+value.titre+'</td><td name="pourcentage_poprock">'+value.poprock+'</td><td name="pourcentage_rap">'+value.rap+'</td><td name="pourcentage_jazzblues">'+value.jazzblues+'</td><td name="pourcentage_musiquemonde">'+value.musiquemonde+'</td><td name="pourcentage_electro">'+value.electro+'</td><td name="pourcentage_hardrock">'+value.hardrock+'</td><td name="pourcentage_chanson">'+value.chanson+'</td><td name=pourcentage_autres>'+value.autres+'</td>';
        ligne+='</tr>';
        compteur++;
      });
      $('#tableau_corps2').append(ligne);
    },
    error: function(){
      console.log('ERREUR recupération playlists depuis la bdd');
    }
  });

  // Option supprimer playlists
  $('#supprimer2').click(function(){
    if(confirm("Confirmer la suppression des clips sélectionnés?")){
      let datas=[];
      $("#tableau_corps2 tr:has(:checked)").each(function() {
        let nom=$(this).find('td').eq(1).html();
        let poprock=$(this).find('td').eq(2).html();
        let rap=$(this).find('td').eq(3).html();
        let jazzblues=$(this).find('td').eq(4).html();
        let monde=$(this).find('td').eq(5).html();
        let electro=$(this).find('td').eq(6).html();
        let hardrock=$(this).find('td').eq(7).html();
		let chanson=$(this).find('td').eq(8).html();
		let autre=$(this).find('td').eq(9).html();
		

        // Création d'un JSON qui contient les informations sur les clips a supprimer
        let obj={};
        obj.nom=nom;
        obj.poprock=poprock;
        obj.rap=rap;
        obj.jazzblues=jazzblues;
		obj.monde=monde;
        obj.electro=electro;
        obj.hardrock=hardrock;
        obj.chanson=chanson;
		obj.autre=autre;

        datas.push(obj);
		
        if(datas.length>0){
          $.post(
            ajaxurl,
            {
              'action':'supprimer_playlists',
              'data':datas
            },function(response){
                $("#tableau_corps2 tr:has(:checked)").each(function(){
                  $(this).remove();
                  console.log(response);
                });
            });
        };
      });
      //console.log(JSON.stringify(data));
    }

  });




  // Scripts pour la modification du tableau -> Update BDD
  //Rendre la case du tableau éditable quand on double clique dessus
  let contenu_avants;
  let contenu_apress;
  let champ_bdds;
  let titres;
  $('#tableau_corps2').on('dblclick','td',function(){

    if ($(this).attr("name")=="pourcentage_poprock"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_poprock'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>"); 
      
    }
    else if($(this).attr("name")=="pourcentage_jazzblues"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
	  $(this).replaceWith("<td name='pourcentage_jazzblues'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>"); 
    }
	    else if ($(this).attr("name")=="pourcentage_rap"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_rap'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>");     //console.log(titre);
    }
    else if($(this).attr("name")=="pourcentage_musiquemonde"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_musiquemonde'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>"); 
    }
	else if ($(this).attr("name")=="pourcentage_electro"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_electro'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>");      //console.log(titre);
    }
    else if($(this).attr("name")=="pourcentage_hardrock"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_hardrock'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>"); 
    }
	else if ($(this).attr("name")=="pourcentage_chanson"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_chanson'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>");       //console.log(titre);
    }
    else if($(this).attr("name")=="pourcentage_autres"){
      contenu_avants=$(this).text();
      champ_bdds=$(this).attr("name");
      titres=$(this).closest('tr').children('td:eq(1)').text();
      $(this).replaceWith("<td name='pourcentage_autres'><select><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='60'>60</option><option value='61'>61</option><option value='62'>62</option><option value='63'>63</option><option value='64'>64</option><option value='65'>65</option><option value='66'>66</option><option value='67'>67</option><option value='68'>68</option><option value='69'>69</option><option value='70'>70</option><option value='71'>71</option><option value='72'>72</option><option value='73'>73</option><option value='74'>74</option><option value='75'>75</option><option value='76'>76</option><option value='77'>77</option><option value='78'>78</option><option value='79'>79</option><option value='80'>80</option><option value='81'>81</option><option value='82'>82</option><option value='83'>83</option><option value='84'>84</option><option value='85'>85</option><option value='86'>86</option><option value='87'>87</option><option value='88'>88</option><option value='89'>89</option><option value='90'>90</option><option value='91'>91</option><option value='92'>92</option><option value='93'>93</option><option value='94'>94</option><option value='95'>95</option><option value='96'>96</option><option value='97'>97</option><option value='98'>98</option><option value='99'>99</option><option value='100'>100</option></select></td>"); 
    }
  });

  //Remettre la case en non éditable a la désélection
  $('#tableau_corps2').on('blur','td',function(){


    if ($(this).attr("name")=="pourcentage_poprock"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_poprock'>"+contenu_apress+"</td>");
		
        if (contenu_avants != contenu_apress) {
			console.log(contenu_avants);
			console.log(contenu_apress);
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "P":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
    if ($(this).attr("name")=="pourcentage_rap"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_rap'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "A":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_jazzblues"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_jazzblues'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "J":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_musiquemonde"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_musiquemonde'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "M":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_electro"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_electro'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "E":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_hardrock"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_chanson'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "H":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_chanson"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_chanson'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "C":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
	      if ($(this).attr("name")=="pourcentage_autres"){
        contenu_apress=$(this).find('select :selected').val();
        $(this).replaceWith("<td name='pourcentage_autres'>"+contenu_apress+"</td>");
        if (contenu_avants != contenu_apress) {
          let update_data={"champ" : champ_bdds,
		  "avant":contenu_avants,
          "A":contenu_apress,
          "titre":titres};
          $.post(
            ajaxurl,{
              'action':'dynamic_updates',
              'data':update_data
          });
        }
      }
    });
	
	
});