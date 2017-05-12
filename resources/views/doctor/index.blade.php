@extends('doctor.layout')
@section('title')
   Xin chào bác sỹ {{ Auth::user()->name }} 
@stop
@section('content')
<div class="panel panel-primary">
        <div class="panel-heading">
            Hệ thông đăng kí khám bệnh 
        </div>
        <div class="panel-body">
        <h2> Giới thiệu chung</h2>
        <p>
            Bệnh viện Bạch Mai (tên giao dịch tiếng Anh: Bach Mai Hospital) nằm ở 78 Giải Phóng, Phương Mai, Đống Đa, Hà Nội. Bệnh viện Bạch Mai là một trong những bệnh viện lớn nhất của Việt Nam.
            Bệnh viện Bạch Mai là bệnh viện đầu tiên trong nước được nhận danh hiệu đặc biệt. Hiện tại bệnh viện Bạch Mai có 1.400 giường bệnh, tất cả trưởng khoa, giám đốc các trung tâm đều có trình độ sau đại học. Tỉ lệ tử vong của bệnh nhân chỉ từ 0,8-0,9% và tỉ lệ sử dụng giường bệnh đạt 153% (so với tiêu chí đề ra là 85%).
            Tháng 10 năm 2009, Bộ trưởng Y tế Nguyễn Quốc Triệu đã làm việc với Bệnh viện Bạch Mai về kế hoạch phát triển bệnh viện thành trung tâm y tế chuyên sâu với tất cả các chuyên ngành về nội khoa. Trong đó, bệnh viện sẽ tập trung phát triển 7 lĩnh vực: tim mạch, hồi sức - cấp cứu - chống độc, thần kinh, y học hạt nhân và ung bướu, chẩn đoán hình ảnh, hoá sinh, vi sinh có trình độ khoa học - kĩ thuật ngang tầm các nước trong khu vực và quốc tế.[4]
        </p>
        <h2>Chức năng, nhiệm vụ</h2>
        <p>
            Khám chữa bệnh cho mọi đối tượng có nhu cầu: BHYT đúng tuyến, tự nguyện.
            Khám, cấp giấy chứng nhận sức khỏe học tập, lao động và người điều khiển các phương tiện giao thông cơ giới trong nước.
            Lấy bệnh phẩm xét nghiệm tại nhà, xét nghiệm theo yêu cầu.
            Khám chữa bệnh và Điều trị ban ngày theo yêu cầu.
            Khám chữa bệnh theo yêu cầu ngoài giờ ngày thứ 7:
            Khám, chữa bệnh cho mọi đối tượng bệnh nhân (có BHYT và không có BHYT).
            Người bệnh có thể lựa chọn thầy thuốc, các GS, PGS, TS.
            Thực hiện các kỹ thuật cao, các trang thiết bị hiện đại.
            Một số dịch vụ y tế khác.
        </p>
        <h2>Những thành tích nổi bật</h2>
        <p>
        <ul></ul>
            <li>Khoa Khám Bệnh đã hoàn thiện và triển khai tốt quy trình khám chữa bệnh một chiều, một cửa. Giải quyết được cơ bản giảm thời gian chờ đợi của người bệnh đến khám và nâng cao chất lượng điều trị.</li>
            <li>Khoa tổ chức tốt công tác đón tiếp, khám chữa bệnh ngoại trú cho tất cả các đối tượng bệnh nhân. 
            Đón tiếp nhanh chóng, hướng dẫn chu đáo, nhiệt tình, từng bước nâng cao sự hài lòng và củng cố niềm tin của người bệnh. Tại nơi đón tiếp và tất cả các buồng khám, người bệnh được tiếp nhận sớm từ 6 giờ hàng ngày (mùa hè 5giờ 30), giải toả nhanh chóng lên các buồng khám để tránh sự ùn tắc tại nơi tiếp đón bệnh nhân ban đầu nhất là trong những giờ cao điểm. Cơ bản giải quyết hết bệnh nhân trong ngày, không để bệnh nhân đến khám phải chờ đến ngày hôm sau (Trừ một số trường hợp đặc biệt phải chờ kết quả xét nghiệm cận lâm sàng và một số xét nghiệm đặc biệt ).</li>
            <li> Tăng cường giám sát việc chẩn đoán, kê đơn phù hợp với chẩn đoán, đúng quy chế kê đơn, bình đơn thuốc thường kỳ hàng tháng của các bác sĩ để kịp thời chấn chỉnh rút kinh nghiệm và học hỏi lẫn nhau để nâng cao chất lượng điều trị cho người bệnh.
            Tăng thời gian khám bệnh, tư vấn cho người bệnh, tiến hành hội chẩn với các chuyên khoa sâu nếu cần để đảm bảo cho người bệnh đến khám được điều trị đúng bệnh. Phối hợp với các khoa cận lâm sàng để có thể có đáp ứng nhu cầu làm xét nghiệm nhanh và chính xác.
            Qui trình lấy bệnh phẩm xét nghiệm đã được cải tiến nhằm phục vụ bệnh nhân một cách nhanh chóng, thuận lợi. Sắp xếp, trả kết quả xét nghiệm tại các buồng khám theo từng chuyên khoa đúng giờ quy định. Bố trí thêm phòng lấy bệnh phẩm và labo xét nghiệm riêng, phục vụ người bệnh đến tư vấn, tái khám cho các khoa trong bệnh viện và khám theo yêu cầu cơ sở 2 tại tầng 4 - khoa Khám bệnh.</li>
            <li>Tăng cường giám sát việc chẩn đoán, kê đơn phù hợp với chẩn đoán, đúng quy chế kê đơn, bình đơn thuốc thường kỳ hàng tháng của các bác sĩ để kịp thời chấn chỉnh rút kinh nghiệm và học hỏi lẫn nhau để nâng cao chất lượng điều trị cho người bệnh.
            Tăng thời gian khám bệnh, tư vấn cho người bệnh, tiến hành hội chẩn với các chuyên khoa sâu nếu cần để đảm bảo cho người bệnh đến khám được điều trị đúng bệnh. Phối hợp với các khoa cận lâm sàng để có thể có đáp ứng nhu cầu làm xét nghiệm nhanh và chính xác.
            Qui trình lấy bệnh phẩm xét nghiệm đã được cải tiến nhằm phục vụ bệnh nhân một cách nhanh chóng, thuận lợi. Sắp xếp, trả kết quả xét nghiệm tại các buồng khám theo từng chuyên khoa đúng giờ quy định. Bố trí thêm phòng lấy bệnh phẩm và labo xét nghiệm riêng, phục vụ người bệnh đến tư vấn, tái khám cho các khoa trong bệnh viện và khám theo yêu cầu cơ sở 2 tại tầng 4 - khoa Khám bệnh.</li>
            <li> Triển khai thêm một số mô hình khám chữa bệnh có chất lượng cao:
            Khoa đã tổ chức khám chữa bệnh theo yêu cầu cơ sở 2 thành công: người bệnh đến khám được tự chọn bác sĩ, khám theo hẹn, thanh toán qua hệ thống ngân hàng sử dụng thẻ, hạn chế dùng tiền mặt, người bệnh không phải đi nộp tiền nhiều lần.
            Phòng điều trị ban ngày khám, theo dõi và điều trị người bệnh đến khám bệnh có yêu cầu nằm điều trị trong ngày, giúp giảm tải cho khu điều trị nội trú, tạo sự hài lòng của người bệnh. Kịp thời xử lý người bệnh cấp cứu đột xuất khi đang khám tại các buồng khám.
            Quản lý một số bệnh mạn tính đã hoàn thiện về chất lượng điều trị cũng như quy trình tổ chức đi vào nề nếp.
            Duy trì, tổ chức tốt công tác khám chữa bệnh ngày thứ 7 với số lượng bệnh nhân khám ngày thứ 7 đã đạt > 1.500 bệnh nhân/ngày, được bệnh nhân hài lòng và ủng hộ.
            Tổ chức khám sức khoẻ định kỳ cho người lao động và người điều khiển các phương tiện giao thông cơ giới. Hướng dẫn chăm sóc sức khoẻ ban đầu, cung cấp thông tin, thường xuyên cập nhật kiến thức, tuyên truyền các biện pháp ngăn ngừa bệnh tật trong cộng đồng.
            Tổ y tế cơ quan quản lý - theo dõi chặt chẽ, cấp giấy nghỉ ốm cho những trường hợp cán bộ nghỉ ốm, thai sản theo đúng quy định. Chuẩn bị đầy đủ các phương tiện, thuốc chống dịch khi có yêu cầu. Định kỳ kiểm tra, lập hồ sơ quản lý, chăm sóc và điều trị cho một số cán bộ của bệnh viện có bệnh mạn tính.</li>
           <li>Tổ chức sinh hoạt khoa học thường kỳ hàng tuần và báo cáo chuyên đề hàng tháng.
            Công tác chỉ đạo tuyến: Tiếp tục tham gia có hiệu quả công tác 1816, bệnh viện vệ tinh. Tham gia các hoạt động chuyên môn, cùng bệnh viện xây dựng thành công hệ thống bệnh viện vệ tinh.
            Khoa đã hoàn thành xuất sắc công tác khám sức khỏe cho các đồng chí Ủy viên Trung ương Đảng mà Đảng ủy và Ban Giám đốc giao cho. Đã được Đảng ủy, Ban giám đốc và Ban bảo vệ sức khỏe Trung ương đánh giá cao.</li>
            
        </ul>
        </p>
        </div>
    </div>
@stop