import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
@Component({
  selector: "app-user",
  templateUrl: "./user.component.html",
  styleUrls: ["./user.component.css"]
})
export class UserComponent implements OnInit {
  urlbase: string;
  user: any[];
  term: any;

  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "user";
  }

  ngOnInit() {
    this.feed_user();
  }

  feed_user() {
    this.http
      .get<any[]>(this.urlbase + "myconn/user/feed_user.php")
      .subscribe(data => {
        this.user = data;
      });
  }
}
