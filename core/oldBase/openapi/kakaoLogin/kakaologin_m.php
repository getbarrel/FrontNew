<?
/**
 * 페이스북 로그인 관련 모델(mallstory 전용)
 *
 * @author bgh
 * @date 2013.07.15
 * 
 */

include ($_SERVER["DOCUMENT_ROOT"]."/class/database.class");

class kalogin_m{
    private $db = null;
        
    public function __construct(){
        $this->db = new Database();
    }
    
    /**
     * 아이디 중복 체크
     * 
     * @param {string} id
     * @return {boolean} T/F
     */
    public function isUsableId($id){
        $sql = "SELECT * FROM common_user WHERE id = '".$id."'";
        $this->db->query($sql);
        
        if($this->db->total){
            return false;
        }else{
            return true;
        }
        
    }
    /**
     * 가입한 회원인지 판단
     * 
     * @param {int} naver id
     * @return {boolean} T/F
     */
    public function isInnaId($id){
        $sql = "SELECT * FROM common_user WHERE ka_id = '".$id."'";
        $this->db->query($sql);
        //syslog(LOG_INFO,"isInnaId : ".$sql);
        if($this->db->total){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 로그인 처리
     * 
     * @param {array} na receive data
     * @return {array} shop member info
     */
    public function kaLoginProcess($data){
        //syslog(LOG_INFO, "id : ".$data["id"]);
        $sql = "SELECT 
                    cu.code,cu.id,
                    AES_DECRYPT(UNHEX(cmd.name),'".$this->db->ase_encrypt_key."') as name,
                    AES_DECRYPT(UNHEX(cmd.pcs),'".$this->db->ase_encrypt_key."') as pcs,
                    cmd.nick_name,
                    AES_DECRYPT(UNHEX(cmd.mail),'".$this->db->ase_encrypt_key."') as mail,
                    mg.gp_level,mg.gp_name, mg.sale_rate, cmd.gp_ix, cu.authorized, cu.is_id_auth, cu.company_id,cu.mem_type
				FROM 
                    common_user cu ,common_member_detail cmd , shop_groupinfo mg
				WHERE 
                    cu.ka_id= '".$data["userID"]."' and cu.mem_type in ('M','F','C','S') 
				    and cu.code = cmd.code
				    and cmd.gp_ix = mg.gp_ix
				    and mg.gp_level != 0
                ";
        $this->db->query($sql);
        //syslog(LOG_INFO,"sql : ".$sql);
        if($this->db->total){
            return $this->db->fetch();
            
        }else{
            return false;
        }
    }
    
    /**
     * 로그인 후 처리
     * 
     * @param {array} login data
     * @return {boolean} T/F
     */
    public function insertLoginData($code){
        $sql = "UPDATE ".TBL_COMMON_USER." SET visit=visit+1, last=NOW(), ip='$REMOTE_ADDR' WHERE code='".$code."'";
        $this->db->query($sql);
        
        $sql = "UPDATE shop_cart SET mem_ix = '".$code."' WHERE cart_key = '".session_id()."'";
        $this->db->query($sql);
        
        return true;
    }

	/**
     * 인증된 아이디가 쇼핑몰에 등록된 아이디인치 체크
     * 
     * @param {array} login data
     * @return {boolean} T/F
     */
    public function idDupCheck($id){
        $sql = "SELECT code FROM common_user where ka_id = '".$id."' LIMIT 1";
		$this->db->query($sql);

		if($this->db->total == 1){
			return false;
		}else{
			return true;
		}
    }
    
    /**
     * 회원관련 테이블에 입력
     * 
     * common_user / common_member_detail / common_company_detail 
     * 
     * @param {array} member data
     * @return {boolean} T/F
     */
    public function insertUserInfo($data){
		/*
        $code  = md5(uniqid(rand()));
        $pw  = md5(uniqid(rand()));
        //$company_id  = md5(uniqid(rand()));
        if($data["gender"] == "M"){
            $sex_div = 'M';
            $add_etc1 = "남";
        }else{
            $sex_div = "W";
            $add_etc1 = "여";
        }
		//company_id = '".$company_id."',
        $sql = "INSERT INTO 
                    common_user
                SET
                    code = '".$code."',
                    id = '".$data["userID"]."',
                    pw = '".$pw."',
                    date = NOW(),
                    ip = '".$_SERVER["REMOTE_ADDR"]."',
                    mem_type = 'M',
                    auth = '1',
                    login_type = 'naver',
                    na_id = '".$data["userID"]."'
                ";
        if($this->db->query($sql)){
            $sql = "INSERT INTO
                        common_member_detail
                    SET
                        code = '".$code."',
                        name = HEX(AES_ENCRYPT('".$data["nickname"]."','".$this->db->ase_encrypt_key."')),
                        date = NOW(),
                        gp_ix = '1',
						mail = HEX(AES_ENCRYPT('".$data["userID"]."','".$this->db->ase_encrypt_key."')),
                        sex_div = '".$sex_div."',
                        add_etc1 = '".$add_etc1."',
                        naver = '".$data["nickname"]."',
                        profile_img = '".$data["profile_img"]."'
                        
                    ";
            if($this->db->query($sql)){

				//20130830 Hong
				include_once($_SERVER['DOCUMENT_ROOT']."/admin/logstory/class/sharedmemory.class");
				
				$shmop = new Shared("reserve_rule");
				//$shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$P->Config["mall_data_root"]."/_shared/";
				$shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/_shared/";// 경로를 $p 클래스에서 가져오기에 에러 발생 kbk 12/04/06
				$shmop->SetFilePath();
				$reserve_data = $shmop->getObjectForKey("reserve_rule");
				$reserve_data = unserialize(urldecode($reserve_data));

				if($reserve_data[reserve_use_yn] == "Y" && $reserve_data[join_reserve_rate] > 0){
					$this->db->query("INSERT INTO ".TBL_SHOP_RESERVE_INFO." (id,uid,oid,pid,ptprice,payprice,reserve,state,etc,regdate) VALUES ('','$code','','','0','0','".$reserve_data[join_reserve_rate]."','1','회원가입 축하 지급 적립금',NOW())");
					
				}
				
				if($_COOKIE['mgm_code']!=""){
					if($reserve_data[mgm_use_yn] == "Y"){

						$this->db->query("select * from ".TBL_COMMON_USER." where id ='".$_COOKIE['mgm_code']."' ");
						$this->db->fetch();
						if($this->db->total){

							$recom_code = $this->db->dt[code];

							//추천인에게
							$this->db->query("INSERT INTO ".TBL_SHOP_RESERVE_INFO." (id,uid,oid,pid,ptprice,payprice,reserve,state,etc,regdate) VALUES ('','$recom_code','','','0','0','".$reserve_data[mgm_reserve]."','1','MGM 회원 추천받은 적립금',NOW())");

							//가입자에게 
							$this->db->query("INSERT INTO ".TBL_SHOP_RESERVE_INFO." (id,uid,oid,pid,ptprice,payprice,reserve,state,etc,regdate) VALUES ('','$code','','','0','0','".$reserve_data[mgm_reserve]."','1','MGM 회원 추천입력 적립금',NOW())");
							
							if(!$_COOKIE['mgm_type']){
								$mgm_type="4";
							}else{
								$mgm_type=$_COOKIE['mgm_type'];
							}

							$this->db->query("insert into mgm_common (mc_ix,code,common_code,common_id,mgm_type,regdate) values('','$recom_code','$code','".$data["email"]."','$mgm_type',NOW())");
						}
					}
				}

				setcookie("mgm_type",'' ,time()-18000000,"/",$HTTP_HOST);
				setcookie("mgm_code",'' ,time()-18000000,"/",$HTTP_HOST);

				return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
		*/
    }
    
    
    
}