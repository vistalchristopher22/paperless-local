import moment from 'moment';
export const addNumberSuffix = (num) => {
    const lastTwoDigits = num % 100;
    const lastDigit = num % 10;

    if (lastTwoDigits >= 11 && lastTwoDigits <= 13) {
        return num + "th";
    } else {
        switch (lastDigit) {
            case 1:
                return num + "st";
            case 2:
                return num + "nd";
            case 3:
                return num + "rd";
            default:
                return num + "th";
        }
    }
};

export const getBaseURL = () => {
    const baseURL = window.location.origin;
    return baseURL;
};

export const removeFileExtension = (fileName) => {
    const extensionPos = fileName.lastIndexOf('.');

    if (extensionPos !== -1) {
        fileName = fileName.substring(0, extensionPos);
    }

    return fileName;
}


export const removeTimestampPrefix = (fileName) => {
    const underscorePos = fileName.indexOf('_');

    if (underscorePos !== -1) {
        fileName = fileName.substring(underscorePos + 1);
    }

    return fileName;
}


export function getIconByFileName(fileName) {
    const extension = fileName.split('.').pop();
    switch (extension) {
        case 'pdf':
            return '/assets-2/images/widgets/pdf-icon.svg';
        case 'docx':
        case 'doc':
            return '/assets-2/images/widgets/word-icon.svg';
        case 'xlsx':
            return '/assets-2/images/widgets/google-sheets-icon.svg';
        case 'pptx':
            return '/assets-2/images/widgets/google-slides-icon.svg';
        default:
            return '/assets-2/images/widgets/image-placeholder.svg';
    }
}

export const getFileBaseName = (file) => {
    const fileName = file;
    const extensionPos = fileName.lastIndexOf('.');

    if (extensionPos !== -1) {
        return fileName.substring(0, extensionPos);
    }

    return fileName;
};

export const getName = (data) => {
    if(data) {
        let file = data.replace(/\//g, "\\");
        let fileName = file.split(["\\"]).pop();
        return removeTimestampPrefix(fileName);
    }
};

export const isRecordNew = (record) => {
    const today = moment().startOf('day');
    return moment(record.created_at).isSame(today, 'day');
};


export const strLimit = (text, limit, end = '...') => {
    if (text.length <= limit) {
      return text;
    }
    return text.substring(0, limit) + end;
  }
  