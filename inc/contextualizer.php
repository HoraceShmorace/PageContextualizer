<?php
require_once('curl.php');
require_once('phpquery.php');
 
class Contextualizer{
	public function __construct($uri){
		if($uri)$this->get($uri);
	}

	public function get($url){
		$this->tags 					= "achondroplasia,acne,adhd,aids,albinism,alcoholic hepatitis,allergy,alopecia,alzheimer's disease,amblyopia,amebiasis,anemia,aneurdu,anorexia,anosmia,anotia,anthrax,appendicitis,apraxia,argyria,arthritis,aseptic meningitis,asthenia,asthma,astigmatism,attention deficit disorder,attention deficit hyperativity disorder,atherosclerosis,athetosis,atrophy,bacterial meningitis,beriberi,black death,botulism,breast cancer,bronchitis,brucellosis,bubonic plague,bunion,bella killer,calculi,campylobacter infection,cancer,candidiasis,carbon monoxide poisoning,celiacs disease,cerebral palsy,chagas disease,chalazion,chancroid,chavia,cherubism,chickenpox,chlamydia,chlamydia trachomatis,cholera,chordoma,chorea,chronic fatigue syndrome,circadian rhythm sleep disorder,coccidioidomycosis,colitis,common cold,condyloma,congestive heart disease,coronary heart disease,cowpox,coxsackie,cretinism,crohn's disease,dengue,diabetes,type 1 diabetes,type 2 diabetes,diabetes mellitus,diphtheria,dehydration,ear infection,ebola,encephalitis,emphysema,epilepsy,erectile dysfunction,foodborne illness,gangrene,gastroenteritis,genital herpes,gerd,goitre,gonorrhea,heart disease,hepatitis a,hepatitis b,hepatitis c,hepatitis d,hepatitis e,histiocytosis,hiv,human papillomavirus,huntington's disease,hypermetropia,hyperopia,hyperthyroidism,hypothermia,hypothyroid,hypotonia,impetigo,infertility,influenza,interstitial cystitis,iritis,iron-deficiency anemia,irritable bowel syndrome,ignious syndrome,jaundice,keloids,kuru,kwashiorkor,laryngitis,lead poisoning,legionellosis,leishmaniasis,leprosy,leptospirosis,listeriosis,leukemia,lice,loiasis,lung cancer,lupus erythematosus,lyme disease,lymphogranuloma venereum,lymphoma,malaria,marburg fever,measles,melanoma,melioidosis,metastatic cancer,ménière's disease,meningitis,migraine,mononucleosis,multiple myeloma,multiple sclerosis,mumps,muscular dystrophy,myasthenia gravis,myelitis,myoclonus,myopia,myxedema,morquio syndrome,mattticular syndrome,neoplasm,non-gonococcal urethritis,necrotizing fasciitis,night blindness,obesity,osteoarthritis,osteoporosis,otitis,palindromic rheumatism,paratyphoid fever,parkinson's disease,pelvic inflammatory disease,peritonitis,periodontal disease,pertussis,phenylketonuria,plague,poliomyelitis,porphyria,progeria,prostatitis,psittacosis,psoriasis,pubic lice,pulmonary embolism,pilia,tet5ee,q fever,ques fever,rabies,repetitive strain injury,rheumatic fever,rheumatic heart,rheumatism,rheumatoid arthritis,rickets,rift valley fever,rocky mountain spotted fever,rubella,salmonellosis,scabies,scarlet fever,sciatica,scleroderma,scrapie,scurvy,sepsis,septicemia,sars,shigellosis,shin splints,shingles,sickle-cell anemia,siderosis,sids,silicosis,smallpox,stevens-johnson syndrome,stomach flu,stomach ulcers,strabismus,strep throat,streptococcal infection,synovitis,syphilis,swine influenza,schizophrenia,taeniasis,tay-sachs disease,tennis elbow,teratoma,tetanus,thalassaemia,thrush,thymoma,tinnitus,tonsillitis,tooth decay,toxic shock syndrome,trichinosis,trichomoniasis,trisomy,tuberculosis,tularemia,tungiasis,typhoid fever,typhus,tumor,ulcerative colitis,ulcers,uremia,urticaria,uveitis,varicella,varicose veins,vasovagal syncope,vitiligo,von hippel-lindau disease,viral fever,viral meningitis,warkany syndrome,warts,watkins,yellow fever,yersiniosis";

		if(!preg_match("/^(http\:|https\:|ftp\:|svn\:)/",$url))
			$url 						= "http://".$url;

		$this->url 						= $url;
		$this->parsed_url				= parse_url($url);
		$this->meta_title 				= "EMPTY";
		$this->meta_description			= "EMPTY";
		$this->meta_keywords 			= "EMPTY";
		$this->body						= "";
		$this->matches					= new stdClass();
		$this->matches->meta_title 		= "NONE";
		$this->matches->meta_description= "NONE";
		$this->matches->meta_keywords 	= "NONE";
		$this->matches->body			= "NONE";
		

		$curl = new CURL();
		$html = $curl->get($this->url);

		$doc = phpQuery::newDocumentHTML($html);
		$doc->find('script')->remove();
		$doc->find('style')->remove();
		$doc->find('link')->remove();
		$doc->find('noscript')->remove();
		phpQuery::selectDocument($doc);

		foreach(pq('meta') as $meta) {
			if($meta->hasAttribute("property"))$k = $meta->getAttribute("property");
			else if($meta->hasAttribute("name"))$k = $meta->getAttribute("name");
			else continue;

			$c = $meta->getAttribute("content");
			if(preg_match("/(\/|\:|\#|\b)title/",$k))
				$this->meta_title = $this->clean($c);
			else if(preg_match("/(\/|\:|\#|\b)description/",$k) && trim($c)!=""){
				$this->meta_description = $c;
				$meta_description_matches = $this->match($this->clean($c));
				$this->matches->meta_description = $meta_description_matches;
			}
			else if(preg_match("/(\/|\:|\#|\b)keywords/",$k) && trim($c)!=""){
				$this->meta_keywords = $c;
				$meta_keywords_matches = $this->match($this->clean($c));
				$this->matches->meta_keywords = $meta_keywords_matches;
			}
		}

		foreach(pq('title') as $t) {
			$title = pq($t)->text();
			$this->title = $title;			
			$title_matches = $this->match($this->clean($title));
			$this->matches->title = $title_matches;
		}
		foreach(pq('body') as $b) {
			$body = pq($b)->text();
			$body = preg_replace("/\\b[\\w']{1,2}\\b/"," ",$body);
			$this->body = $this->clean($body);
			$body_matches = $this->match($this->clean($body));
			$this->matches->body = $body_matches;
		}
	
	}
	private function match($text){
		$matches = array();
		preg_match_all("/(".preg_replace("/,/","|",$this->tags).")/i",$this->clean(strtolower($text)),$matches);
		$matches = array_count_values($matches[0]);
		arsort($matches);
		return $matches;
	}
	private function clean($text){
			$text = strip_tags($text);
			//$text = preg_replace("/\\b[\\w']{1,3}\\b/","",$text);
			$text = preg_replace("/\W+/"," ",$text);
			return trim($text);
	}
}
?>