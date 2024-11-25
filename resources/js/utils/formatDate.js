import dayjs from "dayjs";
import "dayjs/locale/id";

dayjs.locale("id");

export default function formatDate(date, format = "D MMM YYYY HH:mm") {
    return dayjs(date).format(format);
}
