import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";

@Injectable()
export class UrlService {
  //peet: any[];
  constructor(
    public http: HttpClient,
    public router: Router,
    public location: Location,
    public activatedRoute: ActivatedRoute,
    public cookie: CookieService
  ) {}
  gc = this.cookie.get("user_id");
  urlbase = this.get_url();
  time = "Ver. 17/07/2561 08:20 น.";
  nav = "";
  ary: any[] = [{ name: "ผู้ใช้ทั่วไป", user_level: "0" }];

  get_url(): string {
    //return "http://localhost:80/tabler/";
    return "https://greenofficec1.pea.co.th/carpool/";
    //return "https://greenofficec1.pea.co.th/carpool2/";
  }

  del_cookie() {
    this.cookie.delete("user_id");
    this.router.navigate(["/login"]);
  }

  get_cookie() {
    let creds = JSON.stringify({ user_id: this.cookie.get("user_id") });
    this.http
      .post<any[]>(this.urlbase + "myconn/user/user.php", creds)
      .subscribe(data => {
        this.ary = data;
      });
  }
}
