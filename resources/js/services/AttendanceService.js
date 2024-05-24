
export function getPresentRecords(schedule) {
    return Object.values(schedule.attendance_logs_present)?.map((present) => present.sanggunian_member);
}

export function presentGroupByDistrictRecords(schedule) {
    const present = getPresentRecords(schedule);
    return present.reduce((acc, member) => {
        if (!acc[member.district]) {
            acc[member.district] = [];
        }
        acc[member.district].push(member);
        return acc;
    }, {});
}

export function getAbsentRecords(schedule) {
    return Object.values(schedule.attendance_logs_absent)?.map((absent) => absent.sanggunian_member);
}

export function getOnSickLeaveRecords(schedule) {
    return Object.values(schedule.attendance_on_sick_leave)?.map((sickLeave) => sickLeave.sanggunian_member);
}

export function getOfficialBusinessRecords(schedule) {
    return Object.values(schedule.attendance_logs_on_official_business)?.map((officialBusiness) => officialBusiness.sanggunian_member);
}