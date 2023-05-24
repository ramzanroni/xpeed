<?php
	
	class xpeedModel
	{
		// set database config for mysql
		function __construct($consetup)
		{
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;            					
		}
		// open mysql data base
		public function open_db()
		{
			$this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
			if ($this->condb->connect_error) 
			{
    			die("Erron in connection: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}	

		// insert record
		public function insertRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO `xpeed` (`amount`, `buyer`, `receipt_id`, `items`, `buyer_email`, `buyer_ip`, `note`, `city`, `phone`, `hash_key`, `entry_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

				$query->bind_param('sssssssssss',$obj->amount,$obj->buyer, $obj->receipt_id, $obj->items, $obj->buyer_email, $obj->buyer_ip, $obj->note, $obj->city, $obj->phone, $obj->hash_key, $obj->entry_by);
				$query->execute();
				$res= $query->get_result();
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db();
				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}
        
        // select record     
		public function selectRecord($id)
		{
			try
			{
                $this->open_db();
                $query=$this->condb->prepare("SELECT * FROM xpeed");		
				
				$query->execute();
				$res=$query->get_result();	
				$query->close();				
				$this->close_db();                
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
			
		}

		public function searchDateWise($startDate, $endDate, $id)
		{
			try
			{
                $this->open_db();
				$startDate=date('Y-m-d', strtotime($startDate)).' 00:00:00';
				$endDate=date('Y-m-d', strtotime($endDate)).' 23:23:59';
				if($id!=''){
					$query=$this->condb->prepare("SELECT * FROM `xpeed` WHERE `id`='$id'");		

				}else{
					$query=$this->condb->prepare("SELECT * FROM `xpeed` WHERE `entry_at`>='$startDate' AND `entry_at`<='$endDate'");		

				}
				
				$query->execute();
				$res=$query->get_result();	
				$query->close();				
				$this->close_db();                
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
		}
	}

?>