import dayjs from "dayjs";
import "dayjs/locale/id";
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";

dayjs.locale("id");
dayjs.extend(utc);
dayjs.extend(timezone);

export default function formatDate(date, format = "D MMM YYYY HH:mm") {
    return dayjs(date).utc(true).tz("Asia/Makassar").format(format);
}
