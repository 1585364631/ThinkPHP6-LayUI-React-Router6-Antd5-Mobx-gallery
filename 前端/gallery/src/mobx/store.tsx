import {observable, configure, action} from "mobx";
import axios from "axios";
configure({enforceActions:"always"})


class store {
    @observable name = '你好'
    @action setName = (newName:string) => {
        this.name = newName
    }

    @observable dataUpdate = ()=>{

    }
    @action setDataUpdate = (fun:any) => {
        this.dataUpdate = fun
    }

    @observable publicMessage = {
        success(msg: any) {

        },
        error(msg: any) {
            
        }
    }
    @action setPublicMessage = (fun:any)=>{
        this.publicMessage = fun
    }

    @action axios = ()=> axios.create({
        headers: {
            'jwtToken': localStorage.getItem("jwtToken")
        }
    })

    @observable nav:any = null
    @action setNav = (fun:any)=>{
        this.nav = fun
    }

    @action goToLogin = ()=>{
        if(this.nav){
            localStorage.clear()
            setTimeout(()=>{
                this.nav("login")
            },1000)
        }
    }

    @action goToShow = (id: any)=>{
        this.pid = id
        if(this.nav){
            this.nav(`show`,{
                state: {
                    id: id
                }
            })
        }
    }
    @observable updateImageStatus = false
    @action setUpdateImageStatus = (b:boolean) => {
        this.updateImageStatus = b
    }

    @observable updatePAS = ()=>{}
    @action setUpdatePAS = (fun:any)=>{
        this.updatePAS = fun
    }

    @observable updatePAS1 = ()=>{}
    @action setUpdatePAS1 = (fun:any)=>{
        this.updatePAS1 = fun
    }

    @observable pid = 0
    @action setPid = (id:number)=>{
        this.pid = id
    }

    @observable updateImages = ()=>{}
    @action setUpdateImages = (fun:any) => {
        this.updateImages = fun
    }

    @observable Pic = {
        id: undefined,
        photoid: undefined,
        name: undefined,
        test: undefined
    }
    @action setPic = (fun:any) => {
        this.Pic = fun
    }


}

const storeObj = new store()

export default storeObj