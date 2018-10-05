import { Component, OnInit, ViewChild } from "@angular/core";
import { CalendarComponent } from "ng-fullcalendar";
import { Options } from "fullcalendar";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import "rxjs/add/observable/of";
import { HttpClient } from "@angular/common/http";
@Component({
  selector: "app-calen",
  templateUrl: "./calen.component.html",
  styleUrls: ["./calen.component.css"]
})
export class CalenComponent implements OnInit {
  calendarOptions: Options;
  displayEvent: any;
  @ViewChild(CalendarComponent) ucCalendar: CalendarComponent;

  carpool_id: any;
  urlbase: string;
  calen: any[];
  round: any[];
  constructor(
    public http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    this.urlbase = service.get_url();
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
        this.router.navigate(["car"]);
      } else {
        this.carpool_id = params["key"];
        this.getEvents();
        this.veiw_round();
      }
    });
  }
  clickButton(model: any) {
    this.displayEvent = model;
  }
  eventClick(model: any) {
    //swal('จำนวนที่นั่งสูงสุด', 'กรุณากรอกที่นั่งสูงสุด', 'warning')
  }
  updateEvent(model: any) {
    model = {
      event: {
        id: model.event.id,
        start: model.event.start,
        end: model.event.end,
        title: model.event.title
      },
      duration: {
        _data: model.duration._data
      }
    };
    this.displayEvent = model;
  }

  getEvents() {
    this.http
      .get<any[]>(
        this.urlbase +
          "myconn/calendar/feed_calender.php?carpool_id=" +
          this.carpool_id
      )
      .subscribe(data => {
        this.calen = data;
        this.calendarOptions = {
          editable: true,
          eventLimit: false,
          header: {
            left: "prev,next today",
            center: "title",
            right: "month,listMonth"
          },
          events: data
        };
      });
  }

  veiw_round() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/car/feed_car2.php?carpool_id=" + this.carpool_id
      )
      .subscribe(data => {
        this.round = data;
      });
  }
}
