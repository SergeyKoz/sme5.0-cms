<?php
  $this->ImportClass("web.editpage", "EditPage", "libraries");

  /** BizStat page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  BizStat
   * @access public
   **/
   class AutocompletePage extends EditPage {
        var $ClassName="AutocompletePage";
        var $Version="1.0";
        var $moder_page = false;
        var $GetAutocompleteMethod="GetAutocompleteWords";
        var $WordsDelimeter=",";
        var $encoding="utf-8";
        var $PageMode="Frontend";
        var $AutocompleteLibrary="autocomplete";

   	function ControlOnLoad(){

   		$this->word=$this->Page->Request->Value("q");
   		$this->word=iconv("UTF-8", $this->encoding, $this->word);

   		$fields=array("ac_package", "ac_library", "ac_page", "ac_field_table", "ac_field_name", "ac_words_field", "ac_words_delimeter", "ac_autocomplete_method");
        foreach ($fields as $field)
        	if ($this->Page->Request->Value($field)!="")
        		$this->ac[$field]=$this->Page->Request->Value($field);

   		$this->Kernel->Package=Engine::getPackage($this->Kernel,$this->ac["ac_package"],true);
   		$this->Kernel->setDirs();

   		if ($this->ac["ac_library"]!="") $this->AutocompleteLibrary=$this->ac["ac_library"];
   		$this->Request->SetValue("library", $this->AutocompleteLibrary);

   		for ($i = sizeof($this->Kernel->Package->ResourceDirs) - 1; $i >= 0; $i --) {
   			$package_Localization = &ConfigFile::GetInstance("PackageLocalization", $this->Kernel->Package->ResourceDirs[$i] . "localization." . $this->Kernel->Language . ".php");
   			$this->Kernel->Localization->MergeSections($package_Localization);
   			ConfigFile::emptyInstance("PackageLocalization");
   		}

   		parent::ControlOnLoad();
	}

	function CreateChildControls(){
		if ($this->debug_mode) echo $this->ClassName . "::CreateChildControls();" . "<HR>";
        if ($this->listSettings->GetCount()) {
            if ($this->listSettings->HasItem("MAIN", "TABLE"))
                $this->Table = $this->listSettings->GetItem("MAIN", "TABLE");
            else
                $this->AddEditErrorMessage("EMPTY_TABLE_SETTINGS", array(), true);
            if (! $this->error) {
            	$this->InitLibraryData();
                $this->ReInitTableColumns();
            }
        } // if
        else
            $this->AddEditErrorMessage("EMPTY_LIBRARY_SETTINGS", array(), true);

        $words="";

		$WordsDelimeter=($this->ac["ac_words_delimeter"]!="" ? $this->ac["ac_words_delimeter"] : $this->WordsDelimeter);
		if ($this->ac["ac_field_table"]!=""){
			//get from words table
			DataFactory::GetStorage($this, $this->ac["ac_field_table"], "wordsStorage");

			if ($this->wordsStorage->autocomplete_enable){
				$GetAutocompleteMethod=($this->ac["ac_autocomplete_method"]!="" ? $this->ac["ac_autocomplete_method"] : $this->GetAutocompleteMethod ) ;
				$word_field_name=($this->ac["ac_words_field"]!="" ? $this->ac["ac_words_field"] : $this->ac["ac_field_name"]);
				$words=$this->wordsStorage->$GetAutocompleteMethod($this->word, $word_field_name);
			}
		}else{
			//get from
			$SQL=sprintf("SELECT %s AS words FROM %s WHERE %s LIKE '%s%%' OR %s LIKE '%%%s%s%%'",
			$this->ac["ac_field_name"],
			$this->Storage->defaultTableName,
			$this->ac["ac_field_name"], $this->word, $this->ac["ac_field_name"], $WordsDelimeter, $this->word);
			$reader=$this->Storage->Connection->ExecuteReader($SQL);

			$_words=array();
			for ($i=0; $i<$reader->RecordCount; $i++){
				$record=$reader->read();
				$recordwords=explode($WordsDelimeter, $record["words"]);
				foreach ($recordwords AS $word) $_words[]=trim($word);
			}

			$SQL=sprintf(	"SELECT word FROM %s WHERE word LIKE '%s%%' GROUP BY word ORDER BY word",
			"(SELECT '".implode("' AS word UNION SELECT '", $_words)."' AS word) AS words",
			$this->word);

			$reader=$this->Storage->Connection->ExecuteReader($SQL);
			$tags=array();
			for ($i=0; $i<$reader->RecordCount; $i++){
				$record=$reader->read();
				$tags[]=$record["word"];
			}
			$words=implode("\n", $tags);
		}
        header("Content-type: text/plain; charset=".$this->encoding);
        die($words);
	}
}
?>