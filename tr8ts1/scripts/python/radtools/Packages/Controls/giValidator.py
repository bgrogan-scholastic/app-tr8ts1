from wxPython.wx import *
import string

ALPHA_ONLY = 1
DIGIT_ONLY = 2
ALPHA_DIGIT_ONLY = 3

class giValidator(wxPyValidator):
    def __init__(self, flag=None, pyVar=None):
        wxPyValidator.__init__(self)
        self.flag = flag
        EVT_CHAR(self, self.OnChar)

    def Clone(self):
        return giValidator(self.flag)

    def Validate(self, win):
        tc = self.GetWindow()
        val = tc.GetValue()
        if self.flag == ALPHA_ONLY:
            for x in val:
                if x not in string.letters:
                    return false

        elif self.flag == DIGIT_ONLY:
            for x in val:
                if x not in string.digits:
                    return false

        elif self.flag == ALPHA_DIGIT_ONLY:
            for x in val:
                if x not in string.digits or x not in string.letters:
                    return false

        return true


    def OnChar(self, event):
        key = event.KeyCode()
        if key < WXK_SPACE or key == WXK_DELETE or key > 255:
            event.Skip()
            return
        if self.flag == ALPHA_ONLY and chr(key) in string.letters:
            event.Skip()
            return
        if self.flag == DIGIT_ONLY and chr(key) in string.digits:
            event.Skip()
            return
        if self.flag == ALPHA_DIGIT_ONLY and chr(key) in string.digits or chr(key) in string.letters:
            event.Skip()
            return

        if not wxValidator_IsSilent():
            wxBell()

        # Returning without calling even.Skip eats the event before it
        # gets to the text control
        return
