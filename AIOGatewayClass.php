<?

class AIOGateway extends IPSModule
{
    public $InstanceID;
    public function GetParent()
    {
        $instance = IPS_GetInstance($this->InstanceID);//array
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
    }

    //IP Gateway
    public function GetIPGateway()
    {
        $ParentID = $this->GetParent();
        $IPGateway = IPS_GetProperty($ParentID, 'Host');
        return $IPGateway;
    }

    public function GetPassword()
    {
        $ParentID = $this->GetParent();
        $GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
        return $GatewayPassword;
    }

    public function GetGatewaytype()
    {
        $ParentID = $this->GetParent();
        $Gatewaytype = IPS_GetProperty($ParentID, 'gatewaytype');
        return $Gatewaytype;
    }
}


?>