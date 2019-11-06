<?php
/**
 * Created by PHPStorm
 * User: ccl
 * Date: 2019/11/06
 * Time: 18:03
 */
namespace BinaryProtocol\Protocol\Pet;
use BinaryStream\BinaryReader;
use BinaryStream\BinaryWriter;
use BinaryProtocol\BaseMessage;
/**
 * function return pet collect data
 */
class ResAllPetCollect extends BaseMessage
{
    const MSG_ID = 100001;
    /**
     * power level
     * @var int $zPowerLv
     */
    public $zPowerLv;
    /**
     * total experience
     * @var string $totalExp
     */
    public $totalExp;
    /** 
     * fight instance
     * @var array $fightPets 
     */
    public $fightPets;
    /** 
     * pet collect
     * @var array $PetCollect 
     */
    public $PetCollect;
    /** 
     * pet chip
     * @var array $PetChip 
     */
    public $PetChip;
    public function __construct()
    {
        parent::__construct();
        $this->zPowerLv = 0;
        $this->totalExp = '';
        $this->fightPets = [];
        $this->PetCollect = [];
        $this->PetChip = [];
    }
    /**
     * return message ID
     * @return int
     */
    public static function getMsgID(){
        return 100001;
    }
    /**
     * return message ID
     * @return int
     */
    public static function msgID(){
        return 100001;
    }
    /**
     * write buffer data
     * @throws
     * @param BinaryWriter $buffer
     * @return string
     */
    public function write(BinaryWriter $buffer)
    {
        // TODO: Implement write() method.
        $buffer->writeInt32($this->zPowerLv);
        $buffer->writeUTFString($this->totalExp);
        $buffer->writeShort(count($this->fightPets));
        for($i = 0; $i < count($this->fightPets); $i++){
            $this->fightPets[$i]->write($buffer);
        }
        $buffer->writeShort(count($this->PetCollect));
        for($i = 0; $i < count($this->PetCollect); $i++){
            $this->PetCollect[$i]->write($buffer);
        }
        $buffer->writeShort(count($this->PetChip));
        for($i = 0; $i < count($this->PetChip); $i++){
            $this->PetChip[$i]->write($buffer);
        }
        return $buffer->getWriteStream();
    }
    /**
     * read buffer data
     * @param BinaryReader $buffer
     */
    public function read(BinaryReader $buffer)
    {
        // TODO: Implement read() method.
        $this->zPowerLv = $buffer->readInt32();
        $this->totalExp = $buffer->readUTFString();
        $fightPets_len = $buffer->readShort();
        for($i = 0; $i < $fightPets_len; $i++){
            $value = new KFightPet();
            $value->read($buffer);
            $this->fightPets[$i] = $value;
        }
        $PetCollect_len = $buffer->readShort();
        for($i = 0; $i < $PetCollect_len; $i++){
            $value = new PetProperty();
            $value->read($buffer);
            $this->PetCollect[$i] = $value;
        }
        $PetChip_len = $buffer->readShort();
        for($i = 0; $i < $PetChip_len; $i++){
            $value = new PetChip();
            $value->read($buffer);
            $this->PetChip[$i] = $value;
        }
    }
}